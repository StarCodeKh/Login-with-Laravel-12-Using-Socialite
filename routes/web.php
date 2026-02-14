<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware'=>'auth'],function()
{
    Route::get('home',function()
    {
        return view('dashboard.home');
    });
    Route::get('home',function()
    {
        return view('dashboard.home');
    });
});

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\GithubAuthController;
use App\Http\Controllers\Auth\FacebookAuthController;

// Google OAuth Routes
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

// GitHub OAuth Routes
Route::get('/auth/github', [GithubAuthController::class, 'redirect'])->name('github.login');
Route::get('/auth/github/callback', [GithubAuthController::class, 'callback']);

Route::get('/auth/facebook', [FacebookAuthController::class, 'redirect'])->name('facebook.login');
Route::get('/auth/facebook/callback', [FacebookAuthController::class, 'callback']);

Auth::routes();

Route::group(['namespace' => 'App\Http\Controllers\Auth'],function()
{
    // ----------------------------- login ------------------------------------//
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authenticate');
        Route::get('/logout', 'logout')->name('logout');
        Route::get('logout/page', 'logoutPage')->name('logout/page');
    });

    // ----------------------------- register -------------------------------//
    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'register')->name('register');
        Route::post('/register','storeUser')->name('register');    
    });

    // ----------------------------- Forget Password --------------------------//
    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('forget-password', 'showLinkRequestForm')->name('forget-password');    
        Route::post('forget-password', 'sendResetLinkEmail')->name('forget-password');    
    });

    // ---------------------------- Reset Password ----------------------------//
    Route::controller(ResetPasswordController::class)->group(function () {
        Route::get('reset-password/{token}', 'getPassword');
        Route::post('reset-password', 'updatePassword')->name('reset-password');    
    });

    // Lock the screen
    Route::get('/lock', function () {
        session(['locked' => true]);
        return redirect()->route('lockscreen')->with('success', 'Locked successfully!');
    })->name('lock-activate');

    Route::controller(LockScreenController::class)->group(function () {
        // ---------------------------- Lock Screen ---------------------------//
        Route::get('lockscreen', 'lockscreen')->name('lockscreen');
        Route::post('unlock',  'unlock')->name('unlock-screen');
    });

});

Route::group(['namespace' => 'App\Http\Controllers'],function()
{
    Route::middleware('auth')->group(function () {
        // --------------------- dashboard ------------------//
        Route::controller(HomeController::class)->group(function () {
            Route::get('home', 'index')->name('home');
        });
    });

    Route::middleware('auth')->group(function () {
        // --------------------- Pages ------------------//
        Route::prefix('pages')->group(function () {
            Route::controller(PagesController::class)->group(function () {
                Route::get('profile', 'profile')->name('pages/profile');
                Route::get('settings', 'settings')->name('pages/settings');
                Route::get('faqs', 'faqs')->name('pages/faqs');
            });
        });
    });

    Route::middleware('auth')->group(function () {
        // --------------------- Projects ------------------//
        Route::prefix('apps-project')->group(function () {
            Route::controller(ProjectController::class)->group(function () {
                Route::get('list', 'list')->name('apps-project/list');
                Route::get('overview', 'overview')->name('apps-project/overview');
                Route::get('create', 'create')->name('apps-project/create');
            });
        });
    });

    Route::middleware('auth')->group(function () {
        // --------------------- Task ------------------//
        Route::prefix('apps-task')->group(function () {
            Route::controller(TaskController::class)->group(function () {
                Route::get('kanban-board', 'kanbanBoard')->name('apps-task/kanban-board');
                Route::get('list-view', 'listView')->name('apps-task/list-view');
                Route::get('task-details', 'taskDetails')->name('apps-task/task-details');
            });
        });
    });

});
