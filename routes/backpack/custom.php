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
], function () { 

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

    Route::get('view-cadries', 'DashboardController@view_cadries')
        ->name('view_cadries');

    
    Route::get('statistics/mangements', 'DashboardController@management_statistics')
        ->name('management_statistics');

    
    Route::get('organization-statistics', 'DashboardController@org_statistics')
        ->name('org_statistics');

    Route::get('load-cadries', 'ExaminationCrudController@load_cadries')
        ->name('load_cadries');

    
    Route::get('load-users', 'ExaminationCrudController@load_users')
        ->name('load_users');

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
    
    Route::get('exam-teachers', 'DashboardController@exam_teachers')
        ->name('exam_teachers');

    Route::get('active-cadries', 'DashboardController@active_cadries')
        ->name('active_cadries');

    Route::get('exam-teacher-deps/{org_id}/{manag_id}/{user_id}', 'DashboardController@exam_teacher_deps')
        ->name('exam_teacher_deps');
    
    
    Route::get('exam-teacher-dep-positions/{org_id}/{manag_id}/{user_id}/{dep_id}', 'DashboardController@exam_teacher_dep_positions')
        ->name('exam_teacher_dep_positions');
    
    Route::get('exam-teacher-dep-position-cadries/{org_id}/{manag_id}/{user_id}/{dep_id}/{pos_id}', 'DashboardController@exam_teacher_dep_position_cadries')
        ->name('exam_teacher_dep_position_cadries');

    Route::get('control', 'ThemeController@control')
        ->name('control');

    Route::get('theme-cadries/{id}', 'ThemeCrudController@theme_cadries')
        ->name('theme_cadries');

    Route::post('edit_cadry_theme/{id}', 'ThemeCrudController@edit_cadry_theme')
        ->name('edit_cadry_theme');

// Route::post('send-sms-to-worker', 'ExaminationCrudController@postSendSmsToWorker')
//     ->name('post-send-sms-to-worker');

    Route::crud('theme', 'ThemeCrudController');

    Route::crud('organizationcadry', 'OrganizationCadryCrudController');
}); // this should be the absolute last line of this file