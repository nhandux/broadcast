<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
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
    $user = User::where('email', 'aufderhar.devonte@example.org')->limit(1)->get();
    // $user = new User;
    // $user->name = "Nguyễn Đức Nhân";
    // $user->email = time() . "nha@gmail.com";
    // $user->password = "secret";
    // $user->save();

    return view('welcome')->withUser($user);
});

//QUEUE_CONNECTION: database => laravel worker
Route::get('/test-job', function () {
    $data = [
        'email' => 'nhanduc@gmail.com',
        'name' => 'Nhân Đức'
    ];
    dispatch((new App\Jobs\SendMailRegis($data))->onQueue('emails'));
});

//BROADCAST_DRIVER: redis => install redis
Route::get('/test-event', function () {
    $user = new User;
    $user->name = "Nguyễn Đức Nhân";
    $user->email = time() . "nha@gmail.com";
    $user->password = "secret";
    $user->save();
    event(new \App\Events\SendMessage($user));
    return 'Event Run Successfully.';
});

