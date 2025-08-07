<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\AuthUser;
use Illuminate\Support\Facades\DB;
use App\Models\DeviceAssignment;
use App\Models\Device;
use App\Models\User;

class DeviceAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $auth_user = AuthUser::get();
        $device_assignments = DeviceAssignment::with(['device', 'user'])->get();
        return view("admin.device_assignments",['auth_user' => $auth_user,'device_assignments' => $device_assignments]);
    }

    public function new()
    {
        $auth_user = AuthUser::get();
        $devices = Device::get();
        $users = User::get();
        return view('admin.device_assignments',['new'   => '.','auth_user' => $auth_user,'devices' => $devices,'users' => $users]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'device_id'         => 'required',
            'user_id'         => 'required',
        ]);

        $data = $request->all();

        $auth_user = AuthUser::get();

        try{
            DB::beginTransaction();

            DeviceAssignment::create([
                'device_id'              => $data['device_id'],
                'user_id'              => $data['user_id'],
                'note'           => $data['note'] ?? null,
                'start_date'             => $data['start_date'] ?? null,
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
            'redirect' => route('admin.device_assignment.index'),
            'success_msg' => __('device_assignment.success_msg')
        ];  
    }
    public function select($id){
        $auth_user = AuthUser::get();
        $devices = Device::get();
        $users = User::get();
        $device_assignment = DeviceAssignment::with(['device', 'user'])->findOrFail($id);

        return view("admin.device_assignments",['auth_user' => $auth_user,'devices' => $devices,'users' => $users,'device_assignment' => $device_assignment]);
    }
    public function update(Request $request){
        $request->validate([
            'device_id'         => 'required',
            'user_id'         => 'required',
        ]);

            $data = $request->all();

            $auth_user = AuthUser::get();

            try {
                DB::beginTransaction();
                $dataToUpdate = [
                    'device_id'              => $data['device_id'],
                    'user_id'              => $data['user_id'],
                    'note'           => $data['note'] ?? null,
                    'returned_at'             => $data['returned_at'] ?? null,
                ];
                
                DeviceAssignment::whereId($data['id'])->update($dataToUpdate);
                
                DB::commit();
            }catch(\Exception $e){
                DB::rollback();
                report($e);
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'error' => [__('words.post_error')],
                ]);
            }
            return [
                'redirect' => route('admin.device_assignment.index'),
                'success_msg' => __('device_assignment.update_success_msg')
            ];
    }
    public function delete($id)
    {
        $device_assignment = DeviceAssignment::findOrFail($id);
        $device_assignment->delete();

        return ['success_msg' => __('device_assignment.delete_success_msg')];
    }
}
