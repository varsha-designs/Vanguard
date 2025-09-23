<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Vanguard\Http\Controllers\FileController;
use Vanguard\http\controllers\StudentController;
use Vanguard\Http\Controllers\DocumentController;
use Vanguard\Http\Controllers\CourseController;
use Vanguard\Http\Controllers\FacultyController;
use Vanguard\Http\Controllers\DailyActivityController;
use Vanguard\Http\Controllers\FinancialController;
use Vanguard\Http\Controllers\TabsController;
/**
 * Authentication
 */
Route::get('login', 'Auth\LoginController@show');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('auth.logout');

Route::group(['middleware' => ['registration', 'guest']], function () {
    Route::get('register', 'Auth\RegisterController@show');
    Route::post('register', 'Auth\RegisterController@register');
});

Route::emailVerification();

Route::group(['middleware' => ['password-reset', 'guest']], function () {
    Route::resetPassword();
});

/**
 * Two-Factor Authentication
 */
Route::group(['middleware' => 'two-factor'], function () {
    Route::get('auth/two-factor-authentication', 'Auth\TwoFactorTokenController@show')->name('auth.token');
    Route::post('auth/two-factor-authentication', 'Auth\TwoFactorTokenController@update')->name('auth.token.validate');
});

/**
 * Social Login
 */
Route::get('auth/{provider}/login', 'Auth\SocialAuthController@redirectToProvider')->name('social.login');
Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');

/**
 * Impersonate Routes
 */
Route::group(['middleware' => 'auth'], function () {
    Route::impersonate();
});

Route::group(['middleware' => ['auth', 'verified']], function () {

    /**
     * Dashboard
     */
    Route::get('/', 'DashboardController@index')->name('dashboard');

    /**
     * User Profile
     */
    Route::group(['prefix' => 'profile', 'namespace' => 'Profile'], function () {
        Route::get('/', 'ProfileController@show')->name('profile');
        Route::get('activity', 'ActivityController@show')->name('profile.activity');
        Route::put('details', 'DetailsController@update')->name('profile.update.details');

        Route::post('avatar', 'AvatarController@update')->name('profile.update.avatar');
        Route::post('avatar/external', 'AvatarController@updateExternal')
            ->name('profile.update.avatar-external');

        Route::put('login-details', 'LoginDetailsController@update')
            ->name('profile.update.login-details');

        Route::get('sessions', 'SessionsController@index')
            ->name('profile.sessions')
            ->middleware('session.database');

        Route::delete('sessions/{session}/invalidate', 'SessionsController@destroy')
            ->name('profile.sessions.invalidate')
            ->middleware('session.database');
    });

    /**
     * Two-Factor Authentication Setup
     */
    Route::group(['middleware' => 'two-factor'], function () {
        Route::post('two-factor/enable', 'TwoFactorController@enable')->name('two-factor.enable');

        Route::get('two-factor/verification', 'TwoFactorController@verification')
            ->name('two-factor.verification')
            ->middleware('verify-2fa-code');

        Route::post('two-factor/verify', 'TwoFactorController@verify')
            ->name('two-factor.verify')
            ->middleware('verify-2fa-code');

        Route::post('two-factor/disable', 'TwoFactorController@disable')->name('two-factor.disable');
    });

    /**
     * User Management
     */
    Route::resource('users', 'Users\UsersController')
        ->except('update')->middleware('permission:users.manage');

    Route::group(['prefix' => 'users/{user}', 'middleware' => 'permission:users.manage'], function () {
        Route::put('update/details', 'Users\DetailsController@update')->name('users.update.details');
        Route::put('update/login-details', 'Users\LoginDetailsController@update')
            ->name('users.update.login-details');

        Route::post('update/avatar', 'Users\AvatarController@update')->name('user.update.avatar');
        Route::post('update/avatar/external', 'Users\AvatarController@updateExternal')
            ->name('user.update.avatar.external');

        Route::get('sessions', 'Users\SessionsController@index')
            ->name('user.sessions')->middleware('session.database');

        Route::delete('sessions/{session}/invalidate', 'Users\SessionsController@destroy')
            ->name('user.sessions.invalidate')->middleware('session.database');

        Route::post('two-factor/enable', 'TwoFactorController@enable')->name('user.two-factor.enable');
        Route::post('two-factor/disable', 'TwoFactorController@disable')->name('user.two-factor.disable');
    });

    /**
     * Roles & Permissions
     */
    Route::group(['namespace' => 'Authorization'], function () {
        Route::resource('roles', 'RolesController')->except('show')->middleware('permission:roles.manage');

        Route::post('permissions/save', 'RolePermissionsController@update')
            ->name('permissions.save')
            ->middleware('permission:permissions.manage');

        Route::resource('permissions', 'PermissionsController')->middleware('permission:permissions.manage');
    });

    /**
     * Settings
     */
    Route::get('settings', 'SettingsController@general')->name('settings.general')
        ->middleware('permission:settings.general');

    Route::post('settings/general', 'SettingsController@update')->name('settings.general.update')
        ->middleware('permission:settings.general');

    Route::get('settings/auth', 'SettingsController@auth')->name('settings.auth')
        ->middleware('permission:settings.auth');

    Route::post('settings/auth', 'SettingsController@update')->name('settings.auth.update')
        ->middleware('permission:settings.auth');

    Route::post('settings/auth/2fa/enable', 'SettingsController@enableTwoFactor')
        ->name('settings.auth.2fa.enable')
        ->middleware('permission:settings.auth');

    Route::post('settings/auth/2fa/disable', 'SettingsController@disableTwoFactor')
        ->name('settings.auth.2fa.disable')
        ->middleware('permission:settings.auth');

    Route::post('settings/auth/registration/captcha/enable', 'SettingsController@enableCaptcha')
        ->name('settings.registration.captcha.enable')
        ->middleware('permission:settings.auth');

    Route::post('settings/auth/registration/captcha/disable', 'SettingsController@disableCaptcha')
        ->name('settings.registration.captcha.disable')
        ->middleware('permission:settings.auth');

    Route::get('settings/notifications', 'SettingsController@notifications')
        ->name('settings.notifications')
        ->middleware('permission:settings.notifications');

    Route::post('settings/notifications', 'SettingsController@update')
        ->name('settings.notifications.update')
        ->middleware('permission:settings.notifications');

    /**
     * Activity Log
     */
    Route::get('activity', 'ActivityController@index')->name('activity.index')
        ->middleware('permission:users.activity');

    Route::get('activity/user/{user}/log', 'Users\ActivityController@index')->name('activity.user')
        ->middleware('permission:users.activity');
});

/**
 * Installation
 */
Route::group(['prefix' => 'install'], function () {
    Route::get('/', 'InstallController@index')->name('install.start');
    Route::get('requirements', 'InstallController@requirements')->name('install.requirements');
    Route::get('permissions', 'InstallController@permissions')->name('install.permissions');
    Route::get('database', 'InstallController@databaseInfo')->name('install.database');
    Route::get('start-installation', 'InstallController@installation')->name('install.installation');
    Route::post('start-installation', 'InstallController@installation')->name('install.installation');
    Route::post('install-app', 'InstallController@install')->name('install.install');
    Route::get('complete', 'InstallController@complete')->name('install.complete');
    Route::get('error', 'InstallController@error')->name('install.error');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/files/upload', [FileController::class, 'showUploadForm'])->name('files.upload');
    Route::post('/files/upload', [FileController::class, 'upload'])->name('files.upload.post');
    Route::get('/files/history', [FileController::class, 'history'])->name('files.history');
});


Route::middleware(['auth'])->group(function () {
Route::get('/students', [StudentController::class, 'index'])->name('students.index'); // list students
Route::get('/students/create', [StudentController::class, 'create'])->name('students.create'); // show form
Route::post('/students', [StudentController::class, 'store'])->name('students.store'); // save form
// GET /students/{student}/edit
Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');

// PUT /students/{student}
Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');

Route::delete('/student/documents/{id}', [StudentController::class, 'destroyDocument'])->name('student.documents.destroy');


Route::get('/students/{student}/documents', [DocumentController::class, 'index'])
    ->name('students.documents');

Route::delete('students/documents/{id}', [DocumentController::class, 'destroy'])
    ->name('students.documents.destroy');
Route::post('/students/{student}/documents', [DocumentController::class, 'store'])
->name('students.documents.store');

Route::get('/students/{id}/courses', [DailyActivityController::class, 'getStudentCourses']);



// List all courses
Route::get('courses', [CourseController::class, 'index'])->name('courses.index');

// Show form to create a new course
Route::get('courses/create', [CourseController::class, 'create'])->name('courses.create');

// Store new course
Route::post('courses', [CourseController::class, 'store'])->name('courses.store');

// Show form to edit an existing course
Route::get('courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');

// Update an existing course
Route::put('courses/{course}', [CourseController::class, 'update'])->name('courses.update');

// Delete a course
Route::delete('courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');

Route::get('courses/{course}', [CourseController::class, 'show'])->name('courses.show');
});



Route::get('/faculties', [FacultyController::class, 'index'])->name('faculties.index');
Route::get('/faculties/create', [FacultyController::class, 'create'])->name('faculties.create');
Route::post('/faculties', [FacultyController::class, 'store'])->name('faculties.store');
Route::get('/faculties/{faculty}', [FacultyController::class, 'show'])->name('faculties.show');
Route::get('/faculties/{faculty}/edit', [FacultyController::class, 'edit'])->name('faculties.edit');
Route::put('/faculties/{faculty}', [FacultyController::class, 'update'])->name('faculties.update');
Route::delete('/faculties/{faculty}', [FacultyController::class, 'destroy'])->name('faculties.destroy');

Route::middleware('auth')->group(function() {
Route::get('/daily-activities', [DailyActivityController::class, 'index'])->name('daily_activities.index');
Route::get('/daily-activities/create', [DailyActivityController::class, 'create'])->name('daily_activities.create');
Route::post('/daily-activities', [DailyActivityController::class, 'store'])->name('daily_activities.store');
Route::get('/daily-activities/{activity}', [DailyActivityController::class, 'show'])->name('daily_activities.show');
Route::get('/daily-activities/{activity}/edit', [DailyActivityController::class,'edit'])->name('daily_activities.edit');
Route::put('/daily-activities/{activity}', [DailyActivityController::class, 'update'])->name('daily_activities.update');
Route::delete('/daily-activities/{activity}', [DailyActivityController::class, 'destroy'])->name('daily_activities.destroy');
});
Route::get('/financial-model', [FinancialController::class, 'index'])
     ->name('financial.index');



Route::prefix('tabs')->middleware(['auth'])->group(function () {

    Route::get('/profile', [TabsController::class, 'profile'])->name('tabs.profile');
    Route::get('/course-enrollment', [TabsController::class, 'courseEnrollment'])->name('tabs.courseEnrollment');
    Route::get('/activities', [TabsController::class, 'activities'])->name('tabs.activities');
    Route::get('/photos', [TabsController::class, 'photos'])->name('tabs.photos');
Route::get('/students/{id}', [TabsController::class, 'showStudent'])->name('students.show');


});


