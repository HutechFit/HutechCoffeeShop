<?php

declare(strict_types=1);

use Hutech\Routing\Route;

require_once './vendor/autoload.php';
require_once 'Route.php';

Route::add('/', 'HomeController@index');
Route::add('order', 'OrderController@index');
Route::add('cart', 'CartController@index');
Route::add('manager', 'CoffeeController@getAll');
Route::add('add', 'CoffeeController@add');
Route::add('edit', 'CoffeeController@edit');
Route::add('register', 'UserController@index');
Route::add('login', 'UserController@login');
Route::add('logout', 'UserController@logout');
Route::add('signup', 'UserController@addUser');

Route::dispatch();
