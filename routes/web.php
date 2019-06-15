<?php


Route::get('/', function () {
  return 'hello';
})->name('dashboard');

Route::prefix('p-admin')->group(function () {
  Route::middleware(['auth', 'permission'])->group(function () {
    Route::get('/', function () {
      return view('dashboard');
    })->name('dashboard');
    Route::resource('users','UserController')->except(['show']);
    Route::fallback(function(){});
  });
  Auth::routes(['register' => false]);
});
