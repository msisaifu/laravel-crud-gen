<?php


Route::get('/', function () {
  return 'hello';
})->name('dashboard');

Route::prefix('m-admin')->group(function () {
  Route::middleware(['auth', 'permission'])->group(function () {
    Route::get('/', function () {
      return view('dashboard');
    })->name('dashboard');
    Route::resource('users','UserController')->except(['show']);
    //--resource--
		Route::resource('cats','CatController')->except(['show']);
		//--endresource--
    Route::fallback(function(){});
  });
  Auth::routes(['register' => false]);
});
