<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\AuthUser;
use App\Models\User;
use App\Models\UserPermission;
use App\Models\UserPermissionType;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\GlobalVariables;
use App\Http\Helpers\Functions;

class UserPermissionController extends Controller
{
    public function index(Request $request)
    {
        $auth_user = AuthUser::get();
        $search = $request->input('search');

        $query = UserPermission::with('user.approver')
            ->where('user_id', $auth_user->id);

        if (!empty($search)) {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $user_permissions = $query
            ->orderBy('created_at', 'desc')
            ->paginate(3) 
            ->appends(['search' => $search]);

        return view("admin.user_permissions", [
            'auth_user' => $auth_user,
            'user_permissions' => $user_permissions,
            'search' => $search
        ]);
    }

    public function new()
    {
        $auth_user = AuthUser::get();
        $user_permission_types = UserPermissionType::get();
        return view('admin.user_permissions',['new'   => '.','auth_user' => $auth_user,'user_permission_types' => $user_permission_types]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'permission_type_id'         => 'required',
            'description'         => 'required',
            'start_date'         => 'required',
            'end_date'         => 'required',
        ]);

        $data = $request->all();
        $auth_user = AuthUser::get();

        try{
            DB::beginTransaction();

            UserPermission::create([
                'user_id'             => $auth_user['id'],
                'permission_type_id'             => $data['permission_type_id'],
                'start_date'             => $data['start_date'],
                'end_date'             => $data['end_date'],
                'description'             => $data['description'],
                'status'    => 2,//bekliyor durumunda oluşturulmalı.
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
            'redirect' => route('admin.user_permission.index'),
            'success_msg' => __('user_permission.success_msg')
        ];  
    }
    public function select($id){
        $auth_user = AuthUser::get();
        $user_permission = UserPermission::findOrFail($id);
        $user_permission_types = UserPermissionType::get();

        return view("admin.user_permissions",['auth_user' => $auth_user,'user_permission' => $user_permission,'user_permission_types' => $user_permission_types]);
    }
    public function update(Request $request){
        $request->validate([
            'permission_type_id'         => 'required',
            'description'         => 'required',
            'start_date'         => 'required',
            'end_date'         => 'required',
        ]);

        $data = $request->all();
        $auth_user = AuthUser::get();

        try {
            DB::beginTransaction();
            UserPermission::whereId($data['id'])->update([
                'permission_type_id'             => $data['permission_type_id'],
                'start_date'             => $data['start_date'],
                'end_date'             => $data['end_date'],
                'description'             => $data['description'],
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
            'redirect' => route('admin.user_permission.index'),
            'success_msg' => __('user_permission.update_success_msg')
        ];
    }
    public function delete($id)
    {
        $user_permission = UserPermission::findOrFail($id);
        $user_permission->delete();

        return ['success_msg' => __('user_permission.delete_success_msg')];
    }

    public function request_index(Request $request)
    {
        $auth_user = AuthUser::get();
    
        $isApprover = Functions::approverUserIds();
    
        if (!$isApprover) {
            abort(403, 'Yetkisiz erişim.');
        }
    
        $search = $request->input('search');
    
        $user_permissions = UserPermission::with('user')
            ->whereHas('user', function ($query) use ($auth_user, $search) {
                $query->where('approver_user', $auth_user->id);
    
                if (!empty($search)) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                          ->orWhere('description', 'like', "%{$search}%");
                    });
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends(['search' => $search]); // Arama parametresini koru
    
        return view("admin.user_permission_requests", [
            'auth_user' => $auth_user,
            'user_permissions' => $user_permissions,
            'search' => $search, // view’a gönder
        ]);
    }    

    public function update_status(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:0,1',
        ]);
    
        $action = $request->input('action'); // burada mutlaka 0 veya 1 gelir
    
        $permission = UserPermission::findOrFail($id);
        $permission->status = $action;
        $permission->save();

        return [
            'redirect' => route('admin.user_permission_request.index')
        ];
    
    }
    
}
