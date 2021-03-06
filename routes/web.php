<?php

use App\Http\Controllers\CommentController;

Route::get('login', 'Auth\LoginController@showLoginForm');

Route::post('login', 'Auth\LoginController@login');

Route::post('logout', 'Auth\LoginController@logout');

Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');

Route::post('password/reset', 'Auth\ForgotPasswordController@reset');

Route::get('password/reset/{token}', 'Auth\ForgotPasswordController@showResetForm');

Route::post('register/invite', 'UserController@sentInvitationToRegister')->middleware('auth');

Route::get('register/{token}', 'Auth\RegisterController@showRegistrationForm');

Route::post('register/{token}', 'Auth\RegisterController@confirmNewRegistration');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index');

    /**********************************
        Project
    **********************************/

    Route::get('projects', function () {
        return abort(404);
    });

    Route::post('projects', 'ProjectController@store')->middleware('can:create,App\Models\Project');

    Route::get('projects/{project}', 'ProjectController@show')->middleware('can:view,project');

    Route::delete('projects/{project}', 'ProjectController@delete')->middleware('can:delete,project');

    /**********************************
        Team
    **********************************/

    Route::get('teams', function () {
        return abort(404);
    });

    Route::post('teams', 'TeamController@store')->middleware('can:create,App\Models\Team');

    Route::get('teams/{team}', 'TeamController@show')->middleware('can:view,team');

    Route::delete('teams/{team}', 'TeamController@delete')->middleware('can:delete,team');

    /**********************************
     Office
     **********************************/

    Route::get('offices', function () {
        return abort(404);
    });

    Route::post('offices', 'OfficeController@store')->middleware('can:create,App\Models\Office');

    Route::get('offices/{office}', 'OfficeController@show')->middleware('can:view,office');

    Route::delete('offices/{office}', 'OfficeController@delete')->middleware('can:delete,office');

    /**********************************
        Member
     **********************************/

    Route::get('members', 'MemberController@index');

    Route::post('members', 'MemberController@store');

    /**********************************
        Discussions
     **********************************/

    Route::get('discussions', 'DiscussionController@index');

    Route::post('discussions', 'DiscussionController@store')->middleware('can:create,App\Models\Discussion');

    Route::get('discussions/{discussion}', 'DiscussionController@index');

    Route::get('categories', 'CategoryController@index');

    Route::post('discussions/{discussion}/comments', 'CommentController@store');

    /**********************************
        Messages
     **********************************/

    Route::get('messages', 'MessageController@index');

    Route::post('messages', 'MessageController@store');

    Route::delete('messages/{message}', 'MessageController@delete')->middleware('can:delete,message');

    /**********************************
        Events
     **********************************/

    Route::get('events', 'EventController@index');

    Route::get('events/{event}', 'EventController@index');

    Route::get('files', 'FileController@index');

    Route::get('files/{file}', 'FileController@index');

    /**********************************
        Task
    **********************************/

    Route::get('tasks', 'TaskController@index');

    Route::post('tasks', 'TaskController@store')->middleware('can:create,App\Models\Task');

    Route::get('tasks/{task}', 'TaskController@show');

    Route::delete('tasks/{task}', 'TaskController@delete')->middleware('can:delete,task');

    /**********************************
        User
    **********************************/

    Route::get('users', 'UserController@index');

    Route::get('users/{user}', 'UserController@show');

    Route::put('users/{user}/account', 'UserAccountController@update');

    Route::post('users/{user}/avatar', 'UserAvatarController@store');
});

    /**********************************
        Admin
    **********************************/

Route::group(['middleware' => ['auth', 'permission:view admin page'], 'prefix' => 'admin'], function () {
    Route::get('/', 'AdminController@index');

    Route::get('roles', 'RoleController@index');

    Route::post('roles', 'RoleController@store')->middleware('permission:create role');

    Route::delete('roles/{role}', 'RoleController@delete')->middleware('permission:delete role');

    Route::post('roles/{role}/permissions', 'RolePermissionController@store')->middleware('permission:assign permission');

    Route::delete('roles/{role}/permissions', 'RolePermissionController@delete')->middleware('permission:revoke permission');

    Route::get('permissions', 'PermissionController@index')->middleware('permission:view permissions');

    Route::get('activities', 'ActivityController@index');

    Route::get('check-for-update', 'AboutController@checkForUpdate');

    Route::get('update-software', 'AboutController@updateSoftware');
});
