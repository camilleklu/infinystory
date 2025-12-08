<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\StoryGenerator;
use App\Livewire\Register;
use App\Livewire\Login;
use App\Livewire\Header;
use App\Livewire\Profile;
use App\Livewire\Stories;
use App\Livewire\StoryDetail;

Route::get('/', Home::class)->name('home');
Route::get('/story-generate', StoryGenerator::class)->name('story.create');

Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::post('/logout', Header::class)->name('logout');
});

Route::get('/profile', Profile::class)->name('profile')->middleware('auth');

Route::get('/stories', Stories::class)->name('stories');

Route::get('/stories/{story}', StoryDetail::class)->name('story.detail');