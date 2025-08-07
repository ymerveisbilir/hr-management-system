<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\AuthUser;
use App\Models\UserPermissionType;
use Illuminate\Support\Facades\DB;

class UserPermissionTypeController extends Controller
{
    public function index(Request $request)
    {
        $auth_user = AuthUser::get();
        $user_permission_types = UserPermissionType::get();
        return view("admin.user_permission_types",['auth_user' => $auth_user,'user_permission_types' => $user_permission_types]);
    }

    public function new()
    {
        $auth_user = AuthUser::get();
        return view('admin.user_permission_types',['new'   => '.','auth_user' => $auth_user]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name'         => 'required',
        ]);

        $data = $request->all();
        $auth_user = AuthUser::get();

        try{
            DB::beginTransaction();

            UserPermissionType::create([
                'name'             => $data['name'],
            ]);
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
            report($e);
            throw \Illuminate\Validation\ValidationException::withMessages([
                'error' => [__('words.post_error')],
            ]);
        }

        return [
            'redirect' => route('admin.user_permission_type.index'),
            'success_msg' => __('user_permission_type.success_msg')
        ];  
    }
    public function select($id){
        $auth_user = AuthUser::get();
        $user_permission_type = UserPermissionType::findOrFail($id);

        return view("admin.user_permission_types",['auth_user' => $auth_user,'user_permission_type' => $user_permission_type]);
    }
    public function update(Request $request){
        $request->validate([
            'name'         => 'required',
        ]);

            $data = $request->all();

            $auth_user = AuthUser::get();

            try {
                DB::beginTransaction();

                UserPermissionType::whereId($data['id'])->update([
                    'name'             => $data['name'],
                ]);
                
                DB::commit();
            }catch(\Exception $e){
                DB::rollback();
                report($e);
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'error' => [__('words.post_error')],
                ]);
            }
            return [
                'redirect' => route('admin.user_permission_type.index'),
                'success_msg' => __('user_permission_type.update_success_msg')
            ];
    }
    public function delete($id)
    {
        $user_permission_type = UserPermissionType::findOrFail($id);
        $user_permission_type->delete();

        return ['success_msg' => __('user_permission_type.delete_success_msg')];
    }
}
