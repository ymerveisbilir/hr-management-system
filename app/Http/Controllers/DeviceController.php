<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\AuthUser;
use Illuminate\Support\Facades\DB;
use App\Models\Device;

class DeviceController extends Controller
{
    public function index(Request $request)
    {
        $auth_user = AuthUser::get();
        $search = $request->input('search');

        $query = Device::query();

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('serial_number', 'like', "%{$search}%")
                ->orWhere('type', 'like', "%{$search}%");
            });
        }

        $devices = $query
            ->orderBy('created_at', 'desc')
            ->paginate(3)
            ->appends(['search' => $search]);

        return view("admin.devices", [
            'auth_user' => $auth_user,
            'devices' => $devices,
            'search' => $search
        ]);
    }
    public function new()
    {
        $auth_user = AuthUser::get();
        return view('admin.devices',['new'   => '.','auth_user' => $auth_user]);
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

            Device::create([
                'name'              => $data['name'],
                'type'           => $data['type'] ?? null,
                'serial_number'             => $data['serial_number'],
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
            'redirect' => route('admin.device.index'),
            'success_msg' => __('device.success_msg')
        ];  
    }
    public function select($id){
        $auth_user = AuthUser::get();
        $device = Device::findOrFail($id);

        return view("admin.devices",['auth_user' => $auth_user,'device' => $device]);
    }
    public function update(Request $request){
        $request->validate([
            'name'         => 'required',
        ]);

            $data = $request->all();

            $auth_user = AuthUser::get();

            try {
                DB::beginTransaction();
                $dataToUpdate = [
                    'name'           => $data['name'],
                    'type'        => $data['type'] ?? null,
                    'serial_number'          => $data['serial_number'],
                    'description'          => $data['description'],
                ];
                
                Device::whereId($data['id'])->update($dataToUpdate);
                
                DB::commit();
            }catch(\Exception $e){
                DB::rollback();
                report($e);
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'error' => [__('words.post_error')],
                ]);
            }
            return [
                'redirect' => route('admin.device.index'),
                'success_msg' => __('device.update_success_msg')
            ];
    }
    public function delete($id)
    {
        $device = Device::findOrFail($id);
        $device->delete();

        return ['success_msg' => __('device.delete_success_msg')];
    }
}
