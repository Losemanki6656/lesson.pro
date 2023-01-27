<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Cadry;

use App\Models\Organization;
use App\Models\Examination;
use App\Models\DemoCadry;
use App\Models\ExamCadry;
use App\Models\CheckCadry;


class DashboardController
{
    public function statistics(Request $request)
    {   
        $examination_minus = ExamCadry::query()
            ->when(request('organization_id'), function ( $query, $organization_id) {
                return $query->where('organization_id', $organization_id);

            })
            ->when(request('year_exam'), function ( $query, $year_exam) {
                return $query->where('year_exam', $year_exam);

            })
            ->when(request('quar_exam'), function ( $query, $quar_exam) {
                return $query->where('year_quarter', $quar_exam);

            })
            ->where('ball', '<=', 56)->count();

        $examination_plus = ExamCadry::query()
            ->when(request('organization_id'), function ( $query, $organization_id) {
                return $query->where('organization_id', $organization_id);

            })
            ->when(request('year_exam'), function ( $query, $year_exam) {
                return $query->where('year_exam', $year_exam);

            })
            ->when(request('quar_exam'), function ( $query, $quar_exam) {
                return $query->where('year_quarter', $quar_exam);

            })
            ->where('ball', '>=', 56)->count();

        if(request('year_theme')) $year_theme = $request->year_theme; else $year_theme = now()->format('Y');
        if(request('month_theme')) $month_theme = $request->month_theme; else $month_theme = now()->format('m');

        $cadries_demo = CheckCadry::query()
            ->when(request('organization_id'), function ( $query, $organization_id) {
                return $query->where('organization_id', $organization_id);

            })
            ->when(request('year_theme'), function ( $query, $year_theme) {
                return $query->whereYear('date_theme', $year_theme);

            })
            ->when(request('month_theme'), function ( $query, $month_theme) {
                return $query->whereMonth('date_theme', $month_theme);

            })
            ->where('status',false)
            ->count();

        $organizations = Organization::get();
        $org_id = auth()->user()->userorganization->organization_id;
        $cadries = Cadry::RailwayFilter()->count();
        $main_cadries = Cadry::RailwayFilter()->where('status_work', true)->count();

        $cadry30 = Cadry::RailwayFilter()->where('status_young_professional', true)->count();
        $cadrywinter = Cadry::RailwayFilter()->where('status_winter', true)->count();
        $teacher_cadries = Cadry::RailwayFilter()->where('status_position', true)->count();
       
        $breadcrumbs = [
            trans('backpack::crud.admin')     => backpack_url('statistics'),
            trans('backpack::base.statistics') => false,
        ];

        return view('dashboard', [
            'title' => trans('backpack::base.statistics'),
            'breadcrumbs' => $breadcrumbs,
            'cadries' => $cadries,
            'main_cadries' => $main_cadries,
            'cadry30' => $cadry30,
            'teacher_cadries' => $teacher_cadries,
            'organizations' => $organizations,
            'cadrywinter' => $cadrywinter,
            'examination_minus' => $examination_minus,
            'examination_plus' => $examination_plus,
            'cadries_demo' => $cadries_demo
        ]);
    }

    public function asd()
    {
        
        $exam_cadries = ExamCadry::query()
            ->when(request('result_exam'), function ($query, $result_exam) {
                if ($result_exam == 1) {
                    return $query->where('ball','>=', 56);
                }
                else if($result_exam == 2)  {
                    return $query->where('status_exam', true)->where('ball','<', 55);
                }       
            })
            ->when(request('status_exam'), function ($query, $status_exam) {
                if ($status_exam == 1) {
                    return $query->where('status_exam', false)->where('status_dont_exam', true);
                }
                else if($status_exam == 2)  {
                    return $query->where('status_exam', false)->where('status_dont_exam', false);
                }    
            })
            ->when(request('organization_id'), function ($query, $organization_id) {
                return $query->where('organization_id', $organization_id);
            })
            ->when(request('management_id'), function ($query, $management_id) {
                return $query->where('management_id', $management_id);
            })
            ->when(request('year_exam'), function ($query) {
                return $query->whereHas('examination', function($q) {
                    $q->where('year_exam', request('year_exam'));
                });
            })
            ->when(request('year_exam'), function ($query) {
                return $query->whereHas('examination', function($q) {
                    $q->where('year_exam', request('year_exam'));
                });
            })
            ->when(request('year_quarter'), function ($query) {
                return $query->whereHas('examination', function($q) {
                    $q->where('year_quarter', request('year_quarter'));
                });
            })
            ->orderBy('ball','desc')->with(['exams'])->paginate(10);
    }

}
