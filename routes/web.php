<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\EvidenceController;
use App\Http\Controllers\HypothesisController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['role:admin', 'auth']], function () {
  // Menambahkan konfirmasi password untuk semua aksi sensitif terkait manajemen user (edit, update, delete)
  Route::resource('/admin/user', UserController::class)->middleware('password.confirm'); // <--- TAMBAHAN KEAMANAN

  Route::get('/admin/setting', [AppController::class, 'setting'])->name('setting.index');
  Route::put('/admin/setting', [AppController::class, 'setting_update'])->name('setting.update');
  Route::get('/admin/dashboard', [AppController::class, 'dashboard'])->name('dashboard');
  Route::resource('/admin/evidence', EvidenceController::class);
  Route::resource('/admin/hypothesis', HypothesisController::class);
  Route::resource('/admin/diagnosis', DiagnosisController::class);
  Route::get('/admin/rule', [RuleController::class, 'index'])->name('rule.index');
  Route::put('/admin/rule/{rule}', [RuleController::class, 'update'])->name('rule.update');
  
  Route::get('/admin/profile', [AuthController::class, 'profile'])->name('profile.index');
  // Menambahkan konfirmasi password untuk update profile admin
  Route::put('/admin/profile', [AuthController::class, 'profile_update'])
        ->name('profile.update')
        ->middleware('password.confirm'); // <--- TAMBAHAN KEAMANAN
});

Route::group(['middleware' => ['role:admin,user', 'auth']], function () {  
  Route::get('/expert_system', [AppController::class, 'expert_system'])->name('expert_system');
  Route::post('/expert_result', [AppController::class, 'expert_result'])->name('expert_result');
  Route::get('/diagnosa', [LandingController::class, 'diagnosa'])->name('diagnosa');
  Route::post('/hasil', [LandingController::class, 'result'])->name('result');
  Route::get('/hasil/detail/{hypothesis_id}', [LandingController::class, 'showOtherDiagnosis'])->name('more_diagnosis_detail');
  Route::get('/history', [LandingController::class, 'history_page'])->name('history_page');
  Route::get('/history/detail_history/{id}', [LandingController::class, 'history_detail'])->name('historyDetail');
  Route::get('/detail_history/{id}', [LandingController::class, 'history_detail'])->name('history_detail');
  Route::delete('/diagnosa/{id}', [LandingController::class, 'destroy_history'])->name('destroy_history');

  Route::get('/profile', [LandingController::class, 'edit_profile'])->name('profile');
  // Menambahkan konfirmasi password untuk update profile user
  Route::put('/profile/{id}', [LandingController::class, 'profile_update'])
        ->name('profile_update')
        ->middleware('password.confirm'); // <--- TAMBAHAN KEAMANAN
});

Route::middleware(['guest'])->group(function () {
  Route::get('/login', [AuthController::class, 'login'])->name('login');
  Route::post('/login_process', [AuthController::class, 'login_process'])
        ->name('login_process')
        ->middleware('throttle:login');
  Route::get('/add', [LandingController::class, 'add'])->name('add');
  Route::post('/add', [LandingController::class, 'add_user'])->name('add_user');
});

Route::get('/', [LandingController::class, 'index'])->name('index');
Route::get('/index', [LandingController::class, 'index'])->name('index');
Route::get('/hypothesis', [LandingController::class, 'hypothesis_page'])->name('hypothesis_page');
Route::get('/detail/{id}', [LandingController::class, 'hypothesis_detail'])->name('hypothesis_detail');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');