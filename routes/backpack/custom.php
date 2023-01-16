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
    // Route::get('charts/statistic', 'Charts\StatisticChartController@response')->name('charts.'.statistic.'.index');
    Route::crud('examination', 'ExaminationCrudController');
    Route::crud('democadry', 'DemoCadryCrudController');
}); // this should be the absolute last line of this file