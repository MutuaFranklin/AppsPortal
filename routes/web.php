<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', [UsersController::class, 'index'])->name('index');
Route::post('/user', [AdminController::class, 'createNewUser'])->name('createUser');
Route::post('/user/{id}', [AdminController::class, 'updateUser'])->name('updateUser');
Route::get('/user', [AdminController::class, 'listUsers'])->name('listUser');
Route::get('/user/{id}', [AdminController::class, 'showUser'])->name('showUser');
Route::delete('/user/{id}', [AdminController::class, 'deleteUser'])->name('deleteUser');
Route::get('/review', [AdminController::class, 'reviewApplications'])->name('reviewApplications');

Route::post('/status', [AdminController::class, 'createNewStatus'])->name('createNewStatus');
Route::post('/status/{id}', [AdminController::class, 'updateStatus'])->name('updateStatus');
Route::get('/status', [AdminController::class, 'listStatus'])->name('listStatus');
Route::get('/status/{id}', [AdminController::class, 'showStatus'])->name('showStatus');
Route::delete('/status/{id}', [AdminController::class, 'deleteStatus'])->name('deleteStatus');

Route::post('/role', [AdminController::class, 'createNewRole'])->name('createRole');
Route::post('/role/{id}', [AdminController::class, 'updateRole'])->name('updateRole');
Route::get('/role', [AdminController::class, 'listRole'])->name('listRole');
Route::get('/role/{id}', [AdminController::class, 'showRole'])->name('showRole');
Route::get('/publish/{id}', [AdminController::class, 'publishApp'])->name('publishApp');
Route::get('/unpublish/{id}', [AdminController::class, 'unPublishApp'])->name('publishApp');

Route::delete('/role/{id}', [AdminController::class, 'deleteRole'])->name('deleteRole');

Route::post('/application', [AdminController::class, 'createNewApplication'])->name('createNewApplication');
Route::post('/edit/application/{id}', [AdminController::class, 'editApplication'])->name('editApplication');

// Route::post('/application/{id}', [AdminController::class, 'updateApplication'])->name('updateApplication');
Route::get('/application', [AdminController::class, 'listApplications'])->name('listApplication');
Route::get('/application/{id}', [AdminController::class, 'showApplication'])->name('showApplication');
Route::delete('/application/{id}', [AdminController::class, 'deleteApplication'])->name('deleteApplication');
Route::get('/search-app', [UsersController::class, 'searchApp'])->name('searchApp');

Route::post('/login', [UsersController::class, 'postLogin'])->name('login');
Route::get('/logout', [UsersController::class, 'logout'])->name('logout');
Route::get('/login', [UsersController::class, 'showLogin'])->name('showLogin');

Route::get('/register', [UsersController::class, 'showRegister'])->name('showRegister');
Route::post('/register', [UsersController::class, 'postRegister'])->name('postRegister');
Route::get('/forgot-password', [UsersController::class, 'showForgotPassword'])->name('showForgotPassword');
Route::get('/edit/{id}', [UsersController::class, 'editApp']);
Route::get('/applications', [UsersController::class, 'userApplications'])->name('userApplications');
Route::get('/profile', [UsersController::class, 'userProfile'])->name('userProfile');
Route::post('/profile', [UsersController::class, 'updateProfile'])->name('updateProfile');

Route::get('/launch/{app}', [UsersController::class, 'redirectToApp'])->name('redirect');


// http://127.0.0.1:8000/edit/application/1