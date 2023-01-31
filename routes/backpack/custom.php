<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('railway', 'RailwayCrudController');
    Route::crud('organization', 'OrganizationCrudController');
    Route::crud('user', 'UserCrudController');
    Route::crud('education', 'EducationCrudController');
    Route::crud('department', 'DepartmentCrudController');
    Route::crud('userorganization', 'UserOrganizationCrudController');
    Route::crud('position', 'PositionCrudController');
    Route::crud('cadry', 'CadryCrudController');
    Route::crud('teacherworker', 'TeacherWorkerCrudController');

    Route::crud('examination', 'ExaminationCrudController');
    Route::crud('democadry', 'DemoCadryCrudController');

    Route::get('cadries/{id}', 'ExaminationCrudController@cadries')
        ->name('cadries');

    Route::get('statistics', 'DashboardController@statistics')
        ->name('statistics');

    Route::get('load-cadries', 'ExaminationCrudController@load_cadries')
        ->name('load_cadries');
    Route::post('add_cadry_to_exam/{id}', 'ExaminationCrudController@add_cadry_to_exam')
        ->name('add_cadry_to_exam');
    Route::get('delete_exam_cadry/{id}', 'ExaminationCrudController@delete_exam_cadry')
        ->name('delete_exam_cadry');

    Route::get('exam-statistics', 'ExaminationController@exam_statistics')
        ->name('exam_statistics');

    Route::get('exam-themes', 'ExaminationController@exam_themes')
        ->name('exam_themes');

    Route::get('themes', 'ThemeController@themes')
        ->name('themes');

    Route::get('theme-cadries/{id}', 'ThemeCrudController@theme_cadries')
        ->name('theme_cadries');

    Route::post('edit_cadry_theme/{id}', 'ThemeCrudController@edit_cadry_theme')
        ->name('edit_cadry_theme');

// Route::post('send-sms-to-worker', 'ExaminationCrudController@postSendSmsToWorker')
//     ->name('post-send-sms-to-worker');

    Route::crud('theme', 'ThemeCrudController');

}); // this should be the absolute last line of this file