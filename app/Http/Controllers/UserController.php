<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Order;
use App\Models\Logged;
use App\Models\InventoryWatcher;
use Carbon\Carbon;


class UserController extends Controller
{
    
    public function users()
    {
        

        $users = User::all();
        return view('admin.users',compact('users'));
    }

    public function users_get(Request $request)
    {
        $user = User::find($request->user_id);
        if($user->hasRole('admin'))
        {
            $user->role = 'admin';
        }

        $user->role = 'user';
        return response()->json($user);
    }

    public function users_update(Request $request)
    {
        $user_info = $request->validate([
            'first_name'       => 'required|max:100',
            'last_name'              => 'required|max:100',
            'middle_initial'           => 'required|max:100',
            'email'          => 'required|max:255',
            'username'  => 'required|max:255',
            'contact'         => 'required|max:255'
            
        ]);

        if(isset($request->password)){
            $user_info['password'] = bcrypt($request->password);
        }

        $find_user = User::find($request->user_id);
        if($find_user){
            if($request->user_type == 'admin'){
                $find_user->removeRole('user');
            }
            $find_user->removeRole('admin');
            $find_user->assignRole($request->user_type);
            $find_user->update($user_info);
           
            return back()->with('success','User Successfully Updated!');
        }

        return back()->with('error','User not Exist!');
        
    }

    public function summary()
    {
        $top5_sales =  DB::table('orders')
                ->join('inventories','orders.inventory_id','=','inventories.id')
                ->select('inventory_id', DB::raw('SUM(orders.quantity) as total_sales'),'inventories.name as name')
                ->groupBy('inventory_id','name')
                ->orderBy('total_sales','DESC')
                ->limit(10)
                ->get();

        $logs = Logged::orderBy('created_at','DESC')->limit(10)->get();
        $total_inventory = Inventory::count();
        $total_transactions = Order::count();
        $total_deducted  = $summary = DB::table('inventory_watchers')->where('added',false)->sum('quantity');
        $total_added  = $summary = DB::table('inventory_watchers')->where('added',true)->sum('quantity');

        return view('admin.summary',compact('logs','total_inventory','total_transactions','total_deducted','total_added','top5_sales'));

    }

    public function users_delete($id)
    {
        $find_user = User::find($id);
        if(!$find_user)
        {
            return back()->with('error','Inventory not Exist!');
        }

        $find_user->delete();
        return back()->with('success','User Successfully Deleted!');
    }

    public function inventory()
    {
        $categories = Category::all();
        $inventories = Inventory::all();

        return view('admin.inventory',compact('inventories','categories'));
    }

    public function inventory_update(Request $request)
    {
       $credential = $request->validate([
            'category_id'       => 'required|max:100',
            // 'picture'           => 'required|mimes:jpeg,png,jpg,gif,svg',
            'name'              => 'required|max:100',
            'quantity'          => 'required|max:255',
            'unit_measurement'  => 'required|max:255',
            'unit_cost'         => 'required|max:255',
            'net_value'         => 'required|max:255',
        ]); 

      
        // unset($credential['picture']);
        // $file = $request->file('picture') ;
        // $fileName = $file->getClientOriginalName() ;
        // $destinationPath = public_path().'/inventory_images' ;
        // $credential['picture'] = $fileName;

       
       $find_inventory = Inventory::find($request->inventory_id);
       DB::beginTransaction();

        try {
           
            $find_inventory->update($credential);
        
            // $file->move($destinationPath,$fileName);

            DB::commit();
            return back()->with('success','Successfully Added!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error','Something went wrong. Try Again!');
        }

    }

    public function inventory_check(Request $request)
    {
       
        $credential = $request->validate([
            'category_id'       => 'required|max:100',
            'name'              => 'required|max:100',
            'picture'           => 'required|mimes:jpeg,png,jpg,gif,svg',
            'quantity'          => 'required|max:255',
            'unit_measurement'  => 'required|max:255',
            'unit_cost'         => 'required|max:255',
            'net_value'         => 'required|max:255',
        ]);

        unset($credential['picture']);
        $file = $request->file('picture') ;
        $fileName = $file->getClientOriginalName() ;
        $destinationPath = public_path().'/inventory_images' ;

        $credential['picture'] = $fileName;
        $credential['user_id'] = Auth::id();
        $credential['status_id'] = 1;

        //return $credential;

        DB::beginTransaction();

        try {
            Inventory::create($credential);
        
            $file->move($destinationPath,$fileName);

            DB::commit();
            return back()->with('success','Successfully Added!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error','Something went wrong. Try Again!');
        }


        
    }

    public function inventory_suspend($id)
    {
        $find_inventory = Inventory::find($id);
        if(!$find_inventory)
        {
            return back()->with('error','Inventory not Exist!');
        }
        if($find_inventory->status_id == 0)
        {
            $find_inventory->update(['status_id'=> 1]);
        }else 
        {
           $find_inventory->update(['status_id'=> 0]); 
        }    

        
        return back()->with('success','Inventory Suspended Successfully!');
    }

    public function inventory_get(Request $request)
    {
       $find_inventory = Inventory::find($request->inventory_id);
       if($find_inventory){
        return response()->json($find_inventory);
       }
    }

    public function order_check(Request $request)
    {
        $find_inventory = Inventory::find($request->inventory_id);
       if($find_inventory){
        if($find_inventory->quantity < $request->quantity){
            return back()->with('error','Not Enough stock');
        }
        $order = new Order;
        $order->inventory_id = $request->inventory_id;
        $order->quantity     = $request->quantity;
        $order->total        = ($find_inventory->net_value * $request->quantity);    
        $order->save();

        $watcher = new InventoryWatcher;
        $watcher->user_id = Auth::id();
        $watcher->quantity = $request->quantity;
        $watcher->added = false;
        $watcher->save();

        $find_inventory->update(['quantity'=> ($find_inventory->quantity - $request->quantity)]);
        return back()->with('success','Ordered Successfully!');
       }
    }

    public function inventory_stock_update(Request $request)
    {
        $find_inventory = Inventory::find($request->inventory_id);
        if( $find_inventory ){
            $find_inventory->update(['quantity'=> ($find_inventory->quantity + $request->quantity)]);

            $watcher = new InventoryWatcher;
            $watcher->user_id = Auth::id();
            $watcher->quantity = $request->quantity;
            $watcher->added = true;
            $watcher->save();

            return back()->with('success','Stock Update Successfully!');
        }
        return back()->with('error','Something wrong, try again!');
        
    }

    public function product()
    {
        $inventories = Inventory::where('status_id',1)->get();
        return view('admin.product',compact('inventories'));
    }

    public function ordering()
    {
        $orders = Order::with('inventory')->get();
        return view('admin.ordering',compact('orders'));
    }

    public function sales()
    {
        
        

        if(isset($_GET['start_date']) && isset($_GET['end_date'])){
            $start_date = $_GET['start_date'];
            $end_date = $_GET['end_date'];

            

            if(empty($end_date) || is_null($end_date)){
               
                $start_date = $_GET['start_date'];
                $orders = Order::whereDate('created_at', Carbon::parse($start_date))->get();
                $sum = Order::whereDate('created_at', Carbon::parse($start_date))->sum('total');

            }else {
               
                $orders = Order::whereBetween('created_at', [Carbon::parse($start_date), Carbon::parse($end_date)])->get();
                $sum = DB::table('orders')
                    ->whereBetween('created_at', [Carbon::parse($start_date), Carbon::parse($end_date)])
                    
                    ->sum('total');

            }
            

            
        }else {
            $orders = Order::whereDate('created_at', Carbon::now())->get();
            $sum = Order::whereDate('created_at', Carbon::today())->sum('total');
        }
        return view('admin.sales',compact('orders','sum'));
    }
}
