<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\AuthUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Rules\StrongPassword;

class AccountController extends Controller
{
    public function index(){
        $auth_user = AuthUser::get();
        return view('admin.account',['auth_user' => $auth_user]);
    }

    public function update(Request $request){
        $data = $request->all();
        $user = AuthUser::get();
        try
        {
            DB::beginTransaction();

            $array = [
                'name'              => $data['name'],
                'surname'           => $data['surname'],
                'email'             => $data['email'],
                'title'             => $data['title'],
            ];

            User::where('id',$user['id'])->update($array);

            DB::commit();
        }catch(\Exception $e){

            DB::rollback();
            report($e);
            throw \Illuminate\Validation\ValidationException::withMessages([
                'error' => [__('words.post_error')],
            ]);
        }
        return ['redirect' => route('admin.account')];
    }
    public function security_index(){
        $auth_user = AuthUser::get();
        return view('admin.account_security',['auth_user'=>$auth_user]);
    }

    public function security_update(Request $request){
        $request->validate([
            'id'            => 'required',
            'password' => ['required', 'confirmed', new StrongPassword()],

        ]);

        $data = $request->all();

        $user = User::find($data['id']);
        if(!$user) return abort(404);

        if(!Hash::check($data['current_password'],$user['password']))
            throw \Illuminate\Validation\ValidationException::withMessages([
                'current_password' => [__('account.error_current_password')],
            ]);
        
        User::where('id',$data['id'])->update([
            'password' => Hash::make($data['password'])
            ]
        );
        
        return ['success_msg' => __('account.success_change_password')];
    }

}
