<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class UserController extends Controller
{
    
    public function users()
    {
        
        $users = User::all();
        return view('admin.users',compact('users'));
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
            return back()->with('error','Something went wrong. Register Again!');
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

    public function product()
    {
        $inventories = Inventory::where('status_id',1)->get();
        return view('admin.product',compact('inventories'));
    }

    public function ordering()
    {
        return view('admin.ordering');
    }

    public function sales()
    {
        return view('admin.sales');
    }
}
