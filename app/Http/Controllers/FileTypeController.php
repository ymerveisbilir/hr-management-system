<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\AuthUser;
use Illuminate\Support\Facades\DB;
use App\Models\FileType;
use App\Http\Helpers\GlobalVariables;

class FileTypeController extends Controller
{
    public function index(Request $request)
    {
        $auth_user = AuthUser::get();

        $search = $request->input('search');

        $query = FileType::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('allowed_extensions', 'like', "%{$search}%");
        }

        $file_types = $query->orderBy('created_at', 'desc')->paginate(3);

        return view('admin.file_types', [
            'auth_user' => $auth_user,
            'file_types' => $file_types,
            'search' => $search,
        ]);
    }
    public function new()
    {
        $auth_user = AuthUser::get();
        return view('admin.file_types',['new'   => '.','auth_user' => $auth_user]);
    }
    public function create(Request $request)
    {
        $request->validate([
            'name'   => 'required',
            'allowed_extensions' => 'nullable|string',
        ]);

        $data = $request->all();

        $auth_user = AuthUser::get();

        try{
            DB::beginTransaction();

            $allowed_extensions = $data['allowed_extensions'] ?? '';
            $allowed_extensions_array = array_filter(array_map('trim', explode(',', $allowed_extensions)));

            FileType::create([
                'name'              => $data['name'],
                'allowed_extensions'           => $allowed_extensions_array,
                'is_active'             => $data['is_active'],
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
            'redirect' => route('admin.file_type.index'),
            'success_msg' => __('file_type.success_msg')
        ];  
    }
    public function select($id){
        $auth_user = AuthUser::get();
        $file_type = FileType::findOrFail($id);

        return view("admin.file_types",['auth_user' => $auth_user,'file_type' => $file_type]);
    }
    public function update(Request $request){
        $request->validate([
            'name'   => 'required',
            'allowed_extensions' => 'nullable|string',
        ]);

            $data = $request->all();

            $auth_user = AuthUser::get();

            try {
                DB::beginTransaction();

                $allowed_extensions = $data['allowed_extensions'] ?? '';
                $allowed_extensions_array = array_filter(array_map('trim', explode(',', $allowed_extensions)));
            
                $dataToUpdate = [
                    'name'           => $data['name'],
                    'allowed_extensions'        => $allowed_extensions_array,
                    'is_active'          => $data['is_active'],
                ];
                
                FileType::whereId($data['id'])->update($dataToUpdate);
                
                DB::commit();
            }catch(\Exception $e){
                DB::rollback();
                report($e);
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'error' => [__('words.post_error')],
                ]);
            }
            return [
                'redirect' => route('admin.file_type.index'),
                'success_msg' => __('file_type.update_success_msg')
            ];
    }
    public function delete($id)
    {
        $file_type = FileType::findOrFail($id);
        $file_type->delete();

        return redirect()->route('admin.file_type.index')
        ->with('success_msg', __('file_type.delete_success_msg'));
    }
}
