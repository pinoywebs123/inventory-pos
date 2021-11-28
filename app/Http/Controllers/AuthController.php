<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Logged;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
        
    }

    public function login_check(Request $request)
    {
        $credential = $request->validate([
            'username' => 'required|max:255',
            'password' => 'required|max:255',
        ]);


        if( Auth::attempt(['username'=> $credential['username'], 'password'=> $credential['password']]) )
        {
            if(Auth::user()->status_id == 1)
            {
              return back()->with('error','Account is Suspended, Please contact Administrator');  
            }
            $log = new Logged;
            $log->user_id = Auth::user()->id;
            $log->action = 'logged in';
            $log->save();

            if( Auth::user()->hasRole('admin') )
            {
                return redirect()->route('summary');
            }else 
            {
                return redirect()->route('summary');
            }


           
            
            
        }

        return back()->with('error','Invalid Credentials..');
        
    }

    public function logout()
    {
        

        $log = new Logged;
        $log->user_id = Auth::id();
        $log->action = 'logged out';
        $log->save();

        Auth::logout();
        return redirect('/login');
    }

    public function register()
    {
        return view('register');
    }

    public function register_check(Request $request)
    {
        $credential = $request->validate([
            'user_type'         => 'required',
            'first_name'        => 'required|max:255',
            'middle_initial'    => 'required|max:255',
            'last_name'         => 'required|max:255',
            'email'             => 'required|max:255|email|unique:users',
            'username'          => 'required|max:255||unique:users',
            'contact'           => 'required|max:255||unique:users|max:15',
            'password'          => 'required|max:255|min:6',
            'repeat_password'   => 'required|max:255|same:password',
        ]);
        unset($credential['password']);
        unset($credential['repeat_password']);
        unset($credential['user_type']);
        $credential['password'] = bcrypt($request->password);


        DB::beginTransaction();

        try {
            $user = User::create($credential);
            $user->assignRole($request->user_type);

            DB::commit();
            return back()->with('success','Successfully Registered!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error','Something went wrong. Register Again!');
        }


        
       

    }
}
