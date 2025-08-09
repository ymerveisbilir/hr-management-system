<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\AuthUser;
use Illuminate\Support\Facades\DB;
use App\Models\File;
use App\Models\FileType;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index(Request $request)
    {
        $auth_user = AuthUser::get();

        $search = $request->input('search');

        $query = File::query();

        if ($search) {
            $query->where('title', 'like', "%{$search}%")->orWhere('original_name', 'like', "%{$search}%");
        }

        $files = $query->orderBy('created_at', 'desc')->paginate(3);

        return view('admin.files', [
            'auth_user' => $auth_user,
            'files' => $files,
            'search' => $search,
        ]);
    }
    public function new()
    {
        $auth_user = AuthUser::get();
        $file_types = FileType::where('is_active', 1)->get();
        $users = User::get();
        $assignedUsers = [];
        return view('admin.files',['new'   => '.','auth_user' => $auth_user,'file_types' => $file_types,'users' => $users,'assignedUsers' => $assignedUsers]);
    }
    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'upload_file' => 'required|file|max:10240',
            'file_type_id' => 'required|exists:file_types,id',
            'user_id' => 'required|array',
            'user_id.*' => 'exists:users,id',
        ]);
    
        $auth_user = AuthUser::get();
    
        // FileType => allowed_extensions alalım
        $fileType = FileType::findOrFail($request->file_type_id);
        $allowedExtensions = $fileType->allowed_extensions ?? [];
    
        $uploadedFile = $request->file('upload_file');
        $extension = strtolower($uploadedFile->getClientOriginalExtension());
    
        // İzin verilen uzantılarda mı kontrol et
        if (!in_array($extension, $allowedExtensions)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'upload_file' => [__('file.extension_not_allowed', ['ext' => $extension])],
            ]);
        }
    
        try {
            DB::beginTransaction();
    
            $path = $uploadedFile->store('uploads/files', 'public');
    
            $file = File::create([
                'title' => $request->title,
                'file_path' => $path,
                'original_name' => $uploadedFile->getClientOriginalName(),
                'extension' => $extension,
                'mime_type' => $uploadedFile->getMimeType(),
                'size' => $uploadedFile->getSize(),
                'file_type_id' => $request->file_type_id,
                'uploaded_by' => $auth_user->id,
                'is_active' => $request->is_active,
            ]);
    
            // Pivot tabloya kullanıcıları ekleyelim
            $file->users()->sync($request->input('user_id'));
    
            DB::commit();
    
            return [
                'redirect' => route('admin.file.index'),
                'success_msg' => __('file.success_msg'),
            ];
        } catch (\Exception $e) {
            DB::rollback();
            report($e);
            throw \Illuminate\Validation\ValidationException::withMessages([
                'error' => [__('words.post_error')],
            ]);
        }
    }
    
    public function select($id)
    {
        $auth_user = AuthUser::get();
        $file =  File::findOrFail($id);
        $file_types = FileType::where('is_active', 1)->get();
        $assignedUsers = $file->users()->pluck('user_id')->toArray(); 

        $users = User::get();

        return view('admin.files', [
            'auth_user' => $auth_user,
            'file' => $file,
            'file_types' => $file_types,
            'users' => $users,
            'assignedUsers' => $assignedUsers,
        ]);
    }
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:files,id',
            'title' => 'required|string|max:255',
            'upload_file' => 'nullable|file|max:10240',
            'file_type_id' => 'required|exists:file_types,id',
            'user_id' => 'required|array',
            'user_id.*' => 'exists:users,id',
        ]);

        $auth_user = AuthUser::get();

        $file = File::findOrFail($request->id);

        if ($request->hasFile('upload_file')) {
            $fileType = FileType::findOrFail($request->file_type_id);
            $allowedExtensions = $fileType->allowed_extensions ?? [];

            $uploadedFile = $request->file('upload_file');
            $extension = strtolower($uploadedFile->getClientOriginalExtension());

            if (!in_array($extension, $allowedExtensions)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'upload_file' => [__('file.extension_not_allowed', ['ext' => $extension])],
                ]);
            }
        }

        try {
            DB::beginTransaction();

            $dataToUpdate = [
                'title' => $request->title,
                'file_type_id' => $request->file_type_id,
                'is_active' => $request->is_active,
            ];

            if ($request->hasFile('upload_file')) {
                // Eski dosyayı sil
                if (Storage::disk('public')->exists($file->file_path)) {
                    Storage::disk('public')->delete($file->file_path);
                }

                $uploadedFile = $request->file('upload_file');
                $path = $uploadedFile->store('uploads/files', 'public');

                $dataToUpdate = array_merge($dataToUpdate, [
                    'file_path' => $path,
                    'original_name' => $uploadedFile->getClientOriginalName(),
                    'extension' => $extension,
                    'mime_type' => $uploadedFile->getMimeType(),
                    'size' => $uploadedFile->getSize(),
                ]);
            }

            // Dosyayı güncelle
            $file->update($dataToUpdate);

            // Pivot tabloyu güncelle (var olanları silip, yenilerini ekleyelm)
            $file->users()->sync($request->input('user_id'));

            DB::commit();

            return [
                'redirect' => route('admin.file.index'),
                'success_msg' => __('file.update_success_msg'),
            ];
        } catch (\Exception $e) {
            DB::rollback();
            report($e);
            throw \Illuminate\Validation\ValidationException::withMessages([
                'error' => [__('words.post_error')],
            ]);
        }
    }

    public function delete($id)
    {
        $file = File::findOrFail($id);
        $file->delete();

        return ['success_msg' => __('file.delete_success_msg')];
    }
    public function my_file_list(Request $request)
    {
        $auth_user = AuthUser::get();
        $search = $request->input('search');
    
        $query = File::whereHas('users', function ($q) use ($auth_user) {
                $q->where('users.id', $auth_user->id);
            })
            ->with(['fileType', 'uploader']);
    
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('original_name', 'like', "%{$search}%")
                  ->orWhereHas('fileType', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('uploader', function ($q3) use ($search) {
                      $q3->where('name', 'like', "%{$search}%");
                  });
            });
        }
    
        $files = $query
            ->orderBy('created_at', 'desc')
            ->paginate(3)
            ->appends(['search' => $search]);
    
        return view('admin.my_file_list', [
            'files' => $files,
            'search' => $search
        ]);
    }
    
}
