<?php

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides an auto-loader for the application.
|
*/
require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Bootstrap the application and handle the incoming request.
|
*/
 = require_once __DIR__.'/../bootstrap/app.php';

 = ->make(Illuminate\Contracts\Http\Kernel::class);

 = ->handle(
     = Illuminate\Http\Request::capture()
);

->send();

->terminate(, );
