<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::index')->name('pages.index');
Route::livewire('/test-2', 'pages::test2')->name('pages.test2');
