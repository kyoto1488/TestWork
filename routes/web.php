<?php


Route::get('/', 'WelcomeController@home')->name('home');
Route::get('/created', 'CreatedLinkController@get')->name('link.created');
Route::post('/create', 'CreateLinkController@create')->name('link.create');
Route::get('/{short_key}', 'RedirectController@redirect')->name('link.redirect');
Route::get('/{short_key}/edit', 'EditLinkController@show')->name('link.edit');
Route::post('/{short_key}/edit', 'EditLinkController@edit')->name('link.edit.save');
Route::get('/{short_key}/stat', 'StatLinkController@stat')->name('link.stat');
Route::post('/remove', 'RemoveLinkController@remove')->name('link.remove');



