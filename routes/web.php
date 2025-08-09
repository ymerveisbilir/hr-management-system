<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPermissionTypeController;
use App\Http\Controllers\UserPermissionController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DeviceAssignmentController;
use App\Http\Controllers\FileTypeController;
use App\Http\Controllers\FileController;

Route::middleware(['guest'])->group(function () { //ziyaretçiler
Route::get('/login', [AuthController::class, 'login_index'])->name('admin.login');
Route::post('/login', action: [AuthController::class, 'login'])->name('admin.login.post');
});

Route::middleware('auth')->group(function () { //panel kullanıcıları
    Route::get('/', [IndexController::class, 'index'])->name('admin.index');
    Route::post('/logout', [AuthController::class, 'logout'])->name(name: 'admin.logout');

    //Account Routes
    Route::get('/account', action: [AccountController::class, 'index'])->name('admin.account');
    Route::post('/account-update', action: [AccountController::class, 'update'])->name('admin.account.update');
    Route::get('/account-security', action: [AccountController::class, 'security_index'])->name('admin.account_security');
    Route::post('/account-security-update', action: [AccountController::class, 'security_update'])->name('admin.account.security_update');

    Route::middleware('superadmin')->group(function () { //sadece superadmin kullanıcıları
    //User Routes
    Route::get('/users', action: [UserController::class, 'index'])->name('admin.user.index');
    Route::get('/user/new', [UserController::class,'new'])->name('admin.user.new');
    Route::post('/user/create', [UserController::class,'create'])->name('admin.user.create');
    Route::get('/user/select/{id}', [UserController::class,'select'])->name('admin.user.select');
    Route::post('/user/update', [UserController::class, 'update'])->name('admin.user.update');
    Route::post('/user/delete/{id}', [UserController::class, 'delete'])->name('admin.user.delete');

    //User Permission Types Routes 
    Route::get('/user-permission-types', action: [UserPermissionTypeController::class, 'index'])->name('admin.user_permission_type.index');
    Route::get('/user-permission-type/new', [UserPermissionTypeController::class,'new'])->name('admin.user_permission_type.new');
    Route::post('/user-permission-type/create', [UserPermissionTypeController::class,'create'])->name('admin.user_permission_type.create');
    Route::get('/user-permission-type/select/{id}', [UserPermissionTypeController::class,'select'])->name('admin.user_permission_type.select');
    Route::post('/user-permission-type/update', [UserPermissionTypeController::class, 'update'])->name('admin.user_permission_type.update');
    Route::post('/user-permission-type/delete/{id}', [UserPermissionTypeController::class, 'delete'])->name('admin.user_permission_type.delete');

    //Devices Routes
    Route::get('/devices', action: [DeviceController::class, 'index'])->name('admin.device.index');
    Route::get('/device/new', [DeviceController::class,'new'])->name('admin.device.new');
    Route::post('/device/create', [DeviceController::class,'create'])->name('admin.device.create');
    Route::get('/device/select/{id}', [DeviceController::class,'select'])->name('admin.device.select');
    Route::post('/device/update', [DeviceController::class, 'update'])->name('admin.device.update');
    Route::post('/device/delete/{id}', [DeviceController::class, 'delete'])->name('admin.device.delete');

    //Device Assignments Routes
    Route::get('/device-assignments', action: [DeviceAssignmentController::class, 'index'])->name('admin.device_assignment.index');
    Route::get('/device-assignment/new', [DeviceAssignmentController::class,'new'])->name('admin.device_assignment.new');
    Route::post('/device-assignment/create', [DeviceAssignmentController::class,'create'])->name('admin.device_assignment.create');
    Route::get('/device-assignment/select/{id}', [DeviceAssignmentController::class,'select'])->name('admin.device_assignment.select');
    Route::post('/device-assignment/update', [DeviceAssignmentController::class, 'update'])->name('admin.device_assignment.update');
    Route::post('/device-assignment/delete/{id}', [DeviceAssignmentController::class, 'delete'])->name('admin.device_assignment.delete');

    //File Types Routes
    Route::get('/file-types', action: [FileTypeController::class, 'index'])->name('admin.file_type.index');
    Route::get('/file-type/new', [FileTypeController::class,'new'])->name('admin.file_type.new');
    Route::post('/file-type/create', [FileTypeController::class,'create'])->name('admin.file_type.create');
    Route::get('/file-type/select/{id}', [FileTypeController::class,'select'])->name('admin.file_type.select');
    Route::post('/file-type/update', [FileTypeController::class, 'update'])->name('admin.file_type.update');
    Route::post('/file-type/delete/{id}', [FileTypeController::class, 'delete'])->name('admin.file_type.delete');

    //Files Routes
    Route::get('/files', action: [FileController::class, 'index'])->name('admin.file.index');
    Route::get('/file/new', [FileController::class,'new'])->name('admin.file.new');
    Route::post('/file/create', [FileController::class,'create'])->name('admin.file.create');
    Route::get('/file/select/{id}', [FileController::class,'select'])->name('admin.file.select');
    Route::post('/file/update', [FileController::class, 'update'])->name('admin.file.update');
    Route::post('/file/delete/{id}', [FileController::class, 'delete'])->name('admin.file.delete');
    });

    //My File List Routes
    Route::get('/my-file-list', action: [FileController::class, 'my_file_list'])->name('admin.file.my_file_list');

    //My Debits Routes
    Route::get('/my-debit-list', action: [DeviceAssignmentController::class, 'my_debit_list'])->name('admin.device_assignment.my_debit_list');


    //User Permission Routes
    Route::get('/user-permission', action: [UserPermissionController::class, 'index'])->name('admin.user_permission.index');
    Route::get('/user-permission/new', [UserPermissionController::class,'new'])->name('admin.user_permission.new');
    Route::post('/user-permission/create', [UserPermissionController::class,'create'])->name('admin.user_permission.create');
    Route::get('/user-permission/select/{id}', [UserPermissionController::class,'select'])->name('admin.user_permission.select');
    Route::post('/user-permission/update', [UserPermissionController::class, 'update'])->name('admin.user_permission.update');
    Route::post('/user-permission/delete/{id}', [UserPermissionController::class, 'delete'])->name('admin.user_permission.delete');

    Route::get('/user-permission-request', action: [UserPermissionController::class, 'request_index'])->name('admin.user_permission_request.index');
    Route::post('/user_permission/{id}/update-status', [UserPermissionController::class, 'update_status'])->name('admin.user_permission.update_status');

});

