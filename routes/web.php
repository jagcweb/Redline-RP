<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Auth::routes();

Route::post('/register', [App\Http\Controllers\RegisterController::class, 'register'])->name('register.home');
Route::post('/login-normal', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.normal');
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/foro', [App\Http\Controllers\ForoController::class, 'index'])->name('foro.index');
Route::post('/foro/tema-create', [App\Http\Controllers\ForoController::class, 'save'])->name('foro.save');
Route::post('/foro/tema-update/{id}', [App\Http\Controllers\ForoController::class, 'update'])->name('foro.update');
Route::get('/user-image/{filename}', [App\Http\Controllers\ForoController::class, 'getImage'])->name('foro.get_image');

Route::get('/foro/tema/{tema}/{subtema}', [App\Http\Controllers\SubtemaController::class, 'index'])->name('subtema.index');
Route::post('/foro/subtema-create', [App\Http\Controllers\SubtemaController::class, 'save'])->name('subtema.save');
Route::post('/subtema-update', [App\Http\Controllers\SubtemaController::class, 'update'])->name('subtema.update');

Route::post('/foro/post-create', [App\Http\Controllers\PostController::class, 'save'])->name('post.save');
Route::get('/foro/tema/{tema}/{subtema}/{post}', [App\Http\Controllers\PostController::class, 'get'])->name('post.get');
Route::post('/foro/post-close', [App\Http\Controllers\PostController::class, 'close'])->name('post.close');
Route::post('/foro/post-update/{id}', [App\Http\Controllers\PostController::class, 'update'])->name('post.update');
Route::post('/foro/post-delete', [App\Http\Controllers\PostController::class, 'delete'])->name('post.delete');
Route::post('/foro/post-move', [App\Http\Controllers\PostController::class, 'move'])->name('post.move');

Route::post('/foro/comment-create', [App\Http\Controllers\CommentController::class, 'save'])->name('comment.save');
Route::post('/foro/comment-update', [App\Http\Controllers\CommentController::class, 'update'])->name('comment.update');
Route::post('/foro/comment-delete', [App\Http\Controllers\CommentController::class, 'delete'])->name('comment.delete');

Route::get('/foro/mi-cuenta', [App\Http\Controllers\CuentaController::class, 'index'])->name('cuenta.home');
Route::get('/foro/mi-configuracion', [App\Http\Controllers\CuentaController::class, 'config'])->name('cuenta.config');
Route::post('/foro/mi-configuracion/update', [App\Http\Controllers\CuentaController::class, 'update'])->name('cuenta.update');
Route::post('/foro/mi-configuracion/change-password', [App\Http\Controllers\CuentaController::class, 'changePassword'])->name('cuenta.password');

Route::get('/foro/usuario/{username}', [App\Http\Controllers\UserController::class, 'get'])->name('usuario.get');

Route::post('/foro/enviar-mensaje', [App\Http\Controllers\MessageController::class, 'save'])->name('mensaje.save');
Route::get('/foro/cuenta/mensajes', [App\Http\Controllers\MessageController::class, 'get'])->name('mensaje.get');
Route::get('/foro/cuenta/mensajes/mensaje/{id}', [App\Http\Controllers\MessageController::class, 'getMessage'])->name('mensaje.get_message');

Route::get('/admin/get-user-ajax/{type}/{value}', [App\Http\Controllers\AdminController::class, 'getUserAjax'])->name('admin.get_user_ajax');
Route::get('/admin/ban-user/{id}', [App\Http\Controllers\AdminController::class, 'ban'])->name('admin.ban');
Route::get('/admin/unban-user/{id}', [App\Http\Controllers\AdminController::class, 'unban'])->name('admin.unban');
Route::get('/admin/make-user/{id}', [App\Http\Controllers\AdminController::class, 'makeUser'])->name('admin.make_user');
Route::get('/admin/make-mod/{id}', [App\Http\Controllers\AdminController::class, 'makeMod'])->name('admin.make_mod');
Route::get('/admin/make-admin/{id}', [App\Http\Controllers\AdminController::class, 'makeAdmin'])->name('admin.make_admin');