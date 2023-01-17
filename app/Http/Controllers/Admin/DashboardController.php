<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function statistics()
    {
        $organizations = Organization::get();
        $org_id = auth()->user()->userorganization->organization_id;
        $cadries = Cadry::filter()->count();
        $main_cadries = Cadry::filter()->where('status_work', true)->count();
        $cadry30 = Cadry::filter()->where('birth_date','>=','1993-01-01')->whereYear('created_at', '=', now()->format('Y'))->count();
        $teacher_cadries = Cadry::filter()->where('status_position', true)->count();
       
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
            'teacher_cadries' => $teacher_cadries
        ]);
    }
}
