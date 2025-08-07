<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Http\Helpers\AuthUser;
use App\Rules\StrongPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $auth_user = AuthUser::get();
        $users = User::where('created_by',$auth_user['id'])->get();
        return view("admin.users",['auth_user' => $auth_user,'users' => $users]);
    }

    public function new()
    {
        $auth_user = AuthUser::get();
        $approver_users = User::get();
        return view('admin.users',['new'   => '.','auth_user' => $auth_user,'approver_users' => $approver_users]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name'         => 'required',
            'surname'         => 'required',
            'email'          => 'required',
            'password' => ['required', 'confirmed', new StrongPassword()],
        ]);

        $data = $request->all();

        $auth_user = AuthUser::get();

        try{
            DB::beginTransaction();

            User::create([
                'created_by'           => $auth_user['id'],
                'is_superadmin' => false, 
                'name'              => $data['name'] ?? null,
                'surname'           => $data['surname'] ?? null,
                'email'             => $data['email'],
                'title'             => $data['title'],
                'password' => Hash::make($data['password']),
                'approver_user' => $data['approver_user'],
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
            'redirect' => route('admin.user.index'),
            'success_msg' => __('user.success_msg')
        ];  
    }
    public function select($id){
        $auth_user = AuthUser::get();
        $approver_users = User::get();
        $user = User::findOrFail($id);

        return view("admin.users",['auth_user' => $auth_user,'user' => $user,'approver_users' => $approver_users]);
    }
    public function update(Request $request){
        $request->validate([
            'name'         => 'required',
            'surname'         => 'required',
            'email'          => 'required',
            'password' => ['nullable', 'confirmed', new StrongPassword()],
        ]);

            $data = $request->all();

            $auth_user = AuthUser::get();

            try {
                DB::beginTransaction();
                $dataToUpdate = [
                    'created_by'     => $auth_user['id'],
                    'name'           => $data['name'] ?? null,
                    'surname'        => $data['surname'] ?? null,
                    'email'          => $data['email'],
                    'title'          => $data['title'],
                    'approver_user' => $data['approver_user'],
                ];
                
                // Şifre değiştirilmiş mi?
                if (isset($data['password'])) {
                    $dataToUpdate['password'] = Hash::make($data['password']);
                }
                User::whereId($data['id'])->update($dataToUpdate);
                
                DB::commit();
            }catch(\Exception $e){
                DB::rollback();
                report($e);
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'error' => [__('words.post_error')],
                ]);
            }
            return [
                'redirect' => route('admin.user.index'),
                'success_msg' => __('user.update_success_msg')
            ];
    }
    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return ['success_msg' => __('user.delete_success_msg')];
    }
}

    
