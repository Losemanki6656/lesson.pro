<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Cadry;

use App\Models\Organization;
use App\Models\Examination;
use App\Models\DemoCadry;


class DashboardController
{
    public function statistics(Request $request)
    {   
        $month = now()->format('m');
        $year = now()->format('Y');

        if($month >= 1 && $month <= 3) $quarter = 1;
        if($month >= 4 && $month <= 6) $quarter = 2;
        if($month >= 7 && $month <= 9) $quarter = 3;
        if($month >= 10 && $month <= 12) $quarter = 4;

        if($quarter == 1) {
            $year_filter = $year - 1;
            $quarter_old = 4;
        } else {
            $quarter_old = $quarter - 1;
            $year_filter = $year;
        }

        if($month == 1) {
            $year_demo = $year - 1;
            $month_demo = 12;
        } else {
            $month_demo = $month - 1;
            $year_demo = $year;
        }

        
        $examination_minus = Examination::query()
            ->when(request('organization_id'), function ( $query, $organization_id) {
                return $query->where('organization_id', $organization_id);

            })
            ->where('year_exam', $year_filter)->where('year_quarter', $quarter_old)->where('status',false)->count();
        $examination_plus = Examination::query()
            ->when(request('organization_id'), function ( $query, $organization_id) {
                return $query->where('organization_id', $organization_id);

            })
            ->where('year_exam', $year_filter)->where('year_quarter', $quarter_old)->where('status',true)->count();

        
        $cadries_demo = DemoCadry::query()
            ->when(request('organization_id'), function ( $query, $organization_id) {
                return $query->where('organization_id', $organization_id);

            })
            ->whereYear('date_demo', $year_demo)->whereMonth('date_demo', $month_demo)->count();

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

}
