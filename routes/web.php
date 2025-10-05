<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboard\DepartmanController;
use App\Http\Controllers\dashboard\ImprestController;
use App\Http\Controllers\dashboard\IndexController;
use App\Http\Controllers\dashboard\MaadiranController;
use App\Http\Controllers\dashboard\ServiceController;
use App\Http\Controllers\dashboard\SupervisorController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\dashboard\VamController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\dashboard\NewsController;
use App\Http\Controllers\it\ItUserController;
use App\Http\Controllers\view\UserNewsController;
use App\Http\Controllers\view\ViewController;
use App\Http\Middleware\RoleMiddleware;

Route::group([], function () {
    Route::get('/', [ViewController::class, 'index'])->name('view');

    Route::get('user-news/{news}', [ViewController::class, 'show'])->name('user_news.show');

    Route::get('user-news', [UserNewsController::class, 'index'])->name('user_news.index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('/auth')->middleware('guest')->group(function () {

    Route::get('/register', [AuthController::class, 'index'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::prefix('/dashboard')->middleware('auth')->group(function () {

    Route::middleware([RoleMiddleware::class . ':any,author,manager1,admin,humanResources,managerHr,managerM,manager2,subscriber'])->group(function () {

        Route::get('/', [IndexController::class, 'index'])->name('index');
        Route::resource('users', UserController::class);
        Route::resource('departman', DepartmanController::class);
        Route::resource('supervisor', SupervisorController::class);
        Route::resource('service', ServiceController::class);
        Route::resource('vam', VamController::class);
        Route::resource('maadiran', MaadiranController::class);
        Route::resource('imprest', ImprestController::class);
        Route::resource('news', NewsController::class);

        // پروفایل
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
     
    });

    Route::middleware([RoleMiddleware::class . ':any,admin'])->group(function () {
        Route::get('user-roles', [UserRoleController::class, 'index'])->name('admin.user_roles.index');
        Route::get('user-roles/{user}/edit', [UserRoleController::class, 'edit'])->name('admin.user_roles.edit');
        Route::put('user-roles/{user}', [UserRoleController::class, 'update'])->name('admin.user_roles.update');
    });

    Route::middleware([RoleMiddleware::class . ':any,author,manager1,managerHr,manager2'])->group(function () {

        Route::get('vams', [SupervisorController::class, 'vamRequestsForSupervisor'])->name('supervisor.vam.index');
        Route::get('vams/{vam}/edit', [SupervisorController::class, 'editVam'])->name('supervisor.vam.edit');
        Route::put('vams/{vam}', [SupervisorController::class, 'updateVam'])->name('supervisor.vam.update');

        Route::get('services', [SupervisorController::class, 'serviceRequestsForSupervisor'])->name('supervisor.service.index');
        Route::get('services/{service}/edit', [SupervisorController::class, 'editService'])->name('supervisor.service.edit');
        Route::put('services/{service}', [SupervisorController::class, 'updateService'])->name('supervisor.service.update');

        Route::get('maadirans', [SupervisorController::class, 'maadiranRequestsForSupervisor'])->name('supervisor.maadiran.index');
        Route::get('maadirans/{maadiran}/edit', [SupervisorController::class, 'editMaadiran'])->name('supervisor.maadiran.edit');
        Route::put('maadirans/{maadiran}', [SupervisorController::class, 'updateMaadiran'])->name('supervisor.maadiran.update');

        Route::get('imprests', [SupervisorController::class, 'imprestRequestsForSupervisor'])->name('supervisor.imprest.index');
        Route::get('imprests/{imprest}/edit', [SupervisorController::class, 'editImprest'])->name('supervisor.imprest.edit');
        Route::put('imprests/{imprest}', [SupervisorController::class, 'updateImprest'])->name('supervisor.imprest.update');
    });

});
Route::prefix('/it')->middleware('auth')->group(
    function () {

        Route::middleware([RoleMiddleware::class . ':any,it'])->group(
            function () {
                Route::get('/', [ItUserController::class, 'index'])->name('it.user.index');
            }
        );
    }
);