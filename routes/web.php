<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any?}', function () {//any tregon qe po ja lojm vue js mi kontrollu rutat
    return view('welcome');
});
