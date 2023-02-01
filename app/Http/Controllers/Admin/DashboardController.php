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
        $organizations = Organization::get();
    
        $year_theme = now()->format('Y');
        $month_theme = now()->format('m') - 1;
        if($month_theme == 0) {
            $month_theme = 12;
            $year_theme = $year_theme - 1;
        }

        $year_exam = now()->format('Y');
        $month_dem = now()->format('m');

        if($month_dem >= 1 && $month_dem <= 3) 
            $month_exam = 1;  else if($month_dem >= 4 && $month_dem <= 6)
        $month_exam = 2; else  if($month_dem >= 7 && $month_dem <= 9) $month_exam = 3; else $month_exam = 4;

        $month_exam = $month_exam - 1;
        if($month_exam == 0) {
            $month_exam = 4;
            $year_exam = $year_exam - 1;
        }

        $demo_cadry = [];
        $exam_cadries = [];
        $orgs = [];
        $exam_plus = [];
        $exam_minus = [];

        foreach($organizations as $org) {

            $cadries_demo = CheckCadry::where('organization_id', $org->id)->whereYear('date_theme', $year_theme)
                ->whereMonth('date_theme', $month_theme)
                ->where('status', false)->count();
            $demo_cadry[] = [
                'name' => $org->name,
                'y' => $cadries_demo,
                'drilldown' => $org->name
            ];

            $examination_minus = ExamCadry::where('organization_id', $org->id)
                ->where('year_exam', $year_exam)
                ->where('year_quarter', $month_exam)
                ->where('ball', '<=', 56)->count();

            $examination_minus = ExamCadry::where('organization_id', $org->id)
                ->where('year_exam', $year_exam)
                ->where('year_quarter', $month_exam)
                ->where('ball', '>=', 56)->count();
            $orgs[] = $org->name;
            $exam_plus[] = $examination_minus;
            $exam_minus[] = $examination_minus;
        }

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
            'demo_cadry' => $demo_cadry,
            'year_check' => $year_theme,
            'month_check' => $month_theme,
            'orgs' => $orgs,
            'exam_plus' => $exam_plus,
            'exam_minus' => $exam_minus,
            'year_exam' => $year_exam,
            'month_exam' => $month_exam,

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
