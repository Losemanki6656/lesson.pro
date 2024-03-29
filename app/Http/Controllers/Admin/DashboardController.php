<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Cadry;

use App\Models\Organization;
use App\Models\UserOrganization;
use App\Models\Examination;
use App\Models\DemoCadry;
use App\Models\ExamCadry;
use App\Models\CheckCadry;
use App\Models\Management;
use App\Models\Department;
use App\Models\User;
use App\Models\Position;
use App\Models\OrganizationCadry;
use App\Models\OrganizationManagement;


class DashboardController
{
    public function org_statistics(Request $request)
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


        $cadries_demo = CheckCadry::where('organization_id', backpack_user()->userorganization->organization_id)->whereYear('date_theme', $year_theme)
                ->whereMonth('date_theme', $month_theme)
                ->where('status', false)->count();

        $cadries_demo_sababli = CheckCadry::where('organization_id', backpack_user()->userorganization->organization_id)->whereYear('date_theme', $year_theme)
                ->whereMonth('date_theme', $month_theme)
                ->where('status', false)->where('status_dont_check', true)->count();

        $examination_minus = ExamCadry::where('organization_id', backpack_user()->userorganization->organization_id)
                ->where('year_exam', $year_exam)
                ->where('year_quarter', $month_exam)
                ->where('ball', '<', 56)->count();

        $examination_plus = ExamCadry::where('organization_id', backpack_user()->userorganization->organization_id)
                ->where('year_exam', $year_exam)
                ->where('year_quarter', $month_exam)
                ->where('ball', '>=', 56)->count();

     
        $cadries = Cadry::OrgFilter()->count();
        $main_cadries = Cadry::OrgFilter()->where('status_work', true)->count();

        $cadry30 = Cadry::OrgFilter()->where('status_young_professional', true)->count();
        $cadrywinter = Cadry::OrgFilter()->where('status_winter', true)->count();
        $teacher_cadries = Cadry::OrgFilter()->where('status_position', true)->count();
       
        $breadcrumbs = [
            trans('backpack::crud.admin')     => backpack_url('statistics'),
            trans('backpack::base.statistics') => false,
        ];

        $managements = Management::all();

        $a = []; $b = []; 

        foreach($managements as $man) 
        {
            $q = ExamCadry::where('management_id', $man->id)
                    ->where('year_exam', $year_exam)
                    ->where('year_quarter', $month_exam)
                    ->where('ball', '!=', 0);

            if($q->count()) 
                {
                    $z = $q->sum('ball')/$q->count();
                    $a[$man->id] = number_format($z, 2, ',', '');
                }
                 else $a[$man->id] = 0;

            $orgs = OrganizationManagement::where('management_id', $man->id)->pluck('organization_id')->toArray();
            $organizations = Organization::whereIn('id', $orgs)->get();

            foreach ($organizations as $org) {
                $z = $q->where('organization_id', $org->id);

                if($z->count()) 
                        {
                            $koef = $z->sum('ball')/$z->count();
                            $koef = number_format($koef, 2, ',', '');
                        }
                     else 
                     $koef = 0;

                $b[$man->id][] =  [
                    'organization_id' => $org->id,
                    'management_id' => $man->id,
                    'name' => $org->name,
                    'koef' => $koef
                ];
                
            }

        }

        return view('org_dashboard', [
            'title' => trans('backpack::base.statistics'),
            'breadcrumbs' => $breadcrumbs,
            'cadries' => $cadries,
            'main_cadries' => $main_cadries,
            'cadry30' => $cadry30,
            'teacher_cadries' => $teacher_cadries,
            'organizations' => $organizations,
            'cadrywinter' => $cadrywinter,
            'cadries_demo' => $cadries_demo,
            'cadries_demo_sababli' => $cadries_demo_sababli,
            'year_check' => $year_theme,
            'month_check' => $month_theme,
            'year_exam' => $year_exam,
            'month_exam' => $month_exam,
            'managements' => $managements,
            'examination_minus' => $examination_minus,
            'examination_plus' => $examination_plus,
            'a' => $a,
            'b' => $b,
            
        ]);
    }

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

        $demo_cadry = 0;
        $exam_cadries = [];
        $orgs = [];
        $exam_plus = [];
        $exam_minus = [];

        $org_cadries = [];

        $demo_org_cadries = [];
        $teacher_cadry = [];

        foreach($organizations as $org) {

            $cadries_demo = CheckCadry::where('organization_id', $org->id)->whereYear('date_theme', $year_theme)
                ->whereMonth('date_theme', $month_theme)
                ->where('status', false)->count();
            
            $id = $org->id;
            $teacher_cadry[$org->id] = User::whereHas(
                    'roles', function($q){
                        $q->where('name', 'teacher_theme');
                    }
                )
                ->whereHas(
                    'userorganization', function($q) use ($id) {
                        $q->where('organization_id', $id);
                    }
                )
                ->count();
            
            $falexam = ExamCadry::where('organization_id', $org->id)->where('year_exam', $year_exam)
                ->where('year_quarter', $month_exam)->where('status_exam', false)->count();
            $falexamsababli = ExamCadry::where('organization_id', $org->id)->where('year_exam', $year_exam)
                ->where('year_quarter', $month_exam)->where('status_exam', false)->where('status_dont_exam',true)->count();
            
            $falseexam[$org->id] = [
                'count' => $falexam,
                'sababli' => $falexamsababli,
                'sababsiz' => $falexam - $falexamsababli
            ];

            $cadries_demo_sababli = CheckCadry::where('organization_id', $org->id)->whereYear('date_theme', $year_theme)
                ->whereMonth('date_theme', $month_theme)
                ->where('status', false)
                ->where('status_dont_check', true)
                ->count();

            $demo_cadry = $demo_cadry + $cadries_demo;
            $demo_org_cadries[$org->id] = [
                'count' => $cadries_demo,
                'count_sababsiz' => $cadries_demo - $cadries_demo_sababli,
                'count_sababli' => $cadries_demo_sababli,
            ];
            
            $org_cadries[$org->id] = OrganizationCadry::where('organization_id',$org->id)->first();
            $org_main_cadries[$org->id] = Cadry::where('organization_id', $org->id)->where('status',true)->count();
            // ->where('status_work',true)
            $org_winter_cadries[$org->id] = Cadry::where('organization_id', $org->id)->where('status',true)->where('status_winter',true)->count();
            $org_30_cadries[$org->id] = Cadry::where('organization_id', $org->id)->where('status',true)->where('status_young_professional',true)->count();

            $orgs[] = $org->name;
        }
        
        $cadries = OrganizationCadry::get()->sum('count_cadriez');
        $main_cadries = Cadry::RailwayFilter()->count();

        $cadry30 = Cadry::RailwayFilter()->where('status_young_professional', true)->count();
        $cadrywinter = Cadry::RailwayFilter()->where('status_winter', true)->count();
        // $teacher_cadries = Cadry::RailwayFilter()->where('status_position', true)->count();

        $teacher_cadries = User::whereHas(
            'roles', function($q){
                $q->where('name', 'teacher_theme');
            }
        )->count();
       
        $breadcrumbs = [
            trans('backpack::crud.admin')     => backpack_url('statistics'),
            trans('backpack::base.statistics') => false,
        ];

        $managements = Management::all();

        $a = []; $b = []; 

        $second_exam = 0;
        $sec = 0;

        $q = ExamCadry::where('year_exam', $year_exam)
                    ->where('year_quarter', $month_exam)
                    ->where('ball', '!=', 0);

            if($q->count()) 
                {
                    $z = $q->sum('ball')/$q->count();
                    $sec ++ ;
                    $second_exam = $second_exam + (int)$z;
                }
        $examFalse = ExamCadry::where('year_exam', $year_exam)
            ->where('year_quarter', $month_exam)->where('status_exam', false)->count();

        return view('dashboard', [
            'title' => trans('backpack::base.statistics'),
            'teacher_cadry' => $teacher_cadry,
            'demo_org_cadries' => $demo_org_cadries,
            'org_cadries' => $org_cadries,
            'org_main_cadries' => $org_main_cadries,
            'org_winter_cadries' => $org_winter_cadries,
            'org_30_cadries' => $org_30_cadries,
            'breadcrumbs' => $breadcrumbs,
            'second_exam' => (int)($second_exam/$sec),
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
            'managements' => $managements,
            'examFalse' => $examFalse,
            'falseexam' => $falseexam
        ]);
    }

    public function view_cadries(Request $request)
    {

        $breadcrumbs = [
            trans('backpack::crud.admin')     => backpack_url('teachers'),
            trans('backpack::base.teachers') => false,
        ];

        if($request->teacher) {
            $org = $request->org_id;
            $users = User::query()
                ->whereHas('roles', function($query) {
                    return $query->where('name', 'teacher_theme');
                })
                ->whereHas('userorganization', function($query) use ($org) {
                    return $query->where('organization_id', $org);
                })
                ->with('userorganization.organization')
                ->get();

                return view('teachers', [
                    'title' => trans('backpack::base.teachers'),
                    'breadcrumbs' => $breadcrumbs,
                    'users' => $users
                ]);
            //  dd($users);   
        } else {
            $cadries = Cadry::query()
                ->where('status',true)
                ->when(request('org_id'), function ( $query, $org_id) {
                    return $query->where('organization_id', $org_id);

                })
                ->when(request('main'), function ( $query, $main) {
                    return $query->where('status_work', true);

                })
                ->when(request('winter'), function ( $query, $winter) {
                    return $query->where('status_winter', true);

                })
                ->when(request('cadry30'), function ( $query, $cadry30) {
                    return $query->where('status_young_professional', true);

                })
                ->with(['organization','position','department','education'])
                ->paginate(15);
    
                return view('cadries', [
                    'title' => trans('backpack::base.cadries'),
                    'breadcrumbs' => $breadcrumbs,
                    'cadries' => $cadries
                ]);
        }
       
            
        
    }

    public function management_statistics(Request $request)
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

        $demo_cadry = 0;
        $exam_cadries = [];
        $orgs = [];
        $exam_plus = [];
        $exam_minus = [];

        $org_cadries = [];

        foreach($organizations as $org) {

            $cadries_demo = CheckCadry::where('organization_id', $org->id)->whereYear('date_theme', $year_theme)
                ->whereMonth('date_theme', $month_theme)
                ->where('status', false)->count();

            $demo_cadry = $demo_cadry + $cadries_demo;

            
            $org_cadries[$org->id] = Cadry::where('organization_id', $org->id)->where('status',true)->count();
            $org_main_cadries[$org->id] = Cadry::where('organization_id', $org->id)->where('status',true)->where('status_work',true)->count();
            $org_winter_cadries[$org->id] = Cadry::where('organization_id', $org->id)->where('status',true)->where('status_winter',true)->count();
            $org_30_cadries[$org->id] = Cadry::where('organization_id', $org->id)->where('status',true)->where('status_young_professional',true)->count();

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
        
        $cadries = Cadry::RailwayFilter()->count();
        $main_cadries = Cadry::RailwayFilter()->where('status_work', true)->count();

        $cadry30 = Cadry::RailwayFilter()->where('status_young_professional', true)->count();
        $cadrywinter = Cadry::RailwayFilter()->where('status_winter', true)->count();


        $teacher_cadries = User::whereHas(
            'roles', function($q){
                $q->where('name', 'teacher_theme');
            }
        )->count();
       
        $breadcrumbs = [
            trans('backpack::crud.admin')     => backpack_url('statistics'),
            trans('backpack::base.statistics') => false,
        ];

        $managements = Management::all();

        $a = []; $b = []; 

        $second_exam = 0;
        $sec = 0;
        $o = [];
        foreach($managements as $man) 
        {
            $q = ExamCadry::where('management_id', $man->id)
                    ->where('year_exam', $year_exam)
                    ->where('year_quarter', $month_exam)
                    ->where('ball', '!=', 0);

            if($q->count()) 
                {
                    $z = $q->sum('ball')/$q->count();
                    $a[$man->id] = (int)$z;
                    $sec ++ ;
                    $second_exam = $second_exam + (int)$z;
                }
                 else $a[$man->id] = 0;
            $o[$man->id] = $man->fullname;

            $orgs = OrganizationManagement::where('management_id', $man->id)->pluck('organization_id')->toArray();
            $organizations2 = Organization::whereIn('id', $orgs)->get();

            foreach ($organizations2 as $org) {
                $z = ExamCadry::where('management_id', $man->id)
                    ->where('year_exam', $year_exam)
                    ->where('year_quarter', $month_exam)
                    ->where('ball', '!=', 0)->where('organization_id', $org->id);

                if($z->count()) 
                        {
                            $koef = $z->sum('ball')/$z->count();
                            $koef = (int)$koef;
                        }
                     else 
                     $koef = 0;

                $b[$man->id][] =  [
                    'organization_id' => $org->id,
                    'management_id' => $man->id,
                    'name' => $org->name,
                    'koef' => $koef
                ];
                
            }

        }



        return view('dashboard_management', [
            'title' => trans('backpack::base.statistics'),
            'org_cadries' => $org_cadries,
            'org_main_cadries' => $org_main_cadries,
            'org_winter_cadries' => $org_winter_cadries,
            'org_30_cadries' => $org_30_cadries,
            'breadcrumbs' => $breadcrumbs,
            'second_exam' => (int)($second_exam/$sec),
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
            'managements' => $managements,
            'a' => $a,
            'b' => $b,
            'o' => $o
        ]);
    }

    public function exam_teachers(Request $request)
    {
        
        $exam_cadries = ExamCadry::query()
            ->where('management_id', $request->manag_id)
            ->where('organization_id', $request->org_id)
            ->where('status_exam', true)
            ->when(request('result_exam'), function ( $query, $result_exam) {
                if($result_exam == 1)
                return $query->where('ball','>=', 86);
                if($result_exam == 2)
                return $query->where('ball','<', 86)->where('ball','>=', 72);
                if($result_exam == 3)
                return $query->where('ball','>=', 56)->where('ball','<', 72);
                if($result_exam == 4)
                return $query->where('ball','<', 56)->where('ball','>', 0);

            })
            ->when(request('year_exam'), function ( $query, $year) {
                return $query->where('year_exam', $year);

            })
            ->when(request('month_exam'), function ( $query, $month_exam) {
                return $query->where('year_quarter', $month_exam);

            })
            ->orderBy('ball','desc');
        
        return view('backpack::exam_statistics', [
            'title' => trans('backpack::base.statistics'),
            'exam_cadries' => $exam_cadries->paginate(10),
        ]);

       
    }

    public function exam_cadry_view($cadry_id)
    {
        $cadries = ExamCadry::where('cadry_id', $cadry_id)->get();

        return view('backpack::exam_cadry_view', [
            'title' => trans('backpack::base.statistics'),
            'cadries' => $cadries,
        ]);
    }

    public function active_cadries(Request $request)
    {
        $active_cadries = ExamCadry::query()
            ->where('ball', '>=', 80)
            ->when(request('month_exam'), function ( $query, $month_exam) {
                return $query->where('year_quarter', $month_exam);

            })
            ->when(request('year_exam'), function ( $query, $year) {
                return $query->where('year_exam', $year);

            })
            ->when(request('month_exam'), function ( $query, $month_exam) {
                return $query->where('year_quarter', $month_exam);

            })->orderBy('ball','desc');
    
        
        return view('backpack::active_cadries', [
            'title' => trans('backpack::base.statistics'),
            'active_cadries' => $active_cadries->paginate(10),
        ]);
    }

    public function examdontcadries(Request $request)
    {
        $active_cadries = ExamCadry::query()
            ->where('status_exam', false)
            ->when(request('org_id'), function ( $query, $org_id) {
                return $query->where('organization_id', $org_id);

            })
            ->when(request('month_exam'), function ( $query, $month_exam) {
                return $query->where('year_quarter', $month_exam);

            })
            ->when(request('result_exam'), function ( $query, $result_exam) {
                if($result_exam == 1) {
                    return $query->where('status_dont_exam', true);
                } else {
                    return $query->where('status_dont_exam', false);
                }
                

            })
            ->when(request('year_exam'), function ( $query, $year) {
                return $query->where('year_exam', $year);

            });
        
        return view('backpack::dont_exam_cadries', [
            'title' => trans('backpack::base.statistics'),
            'active_cadries' => $active_cadries->paginate(10),
        ]);
    }

    
    public function exam_teacher_deps($org_id, $manag_id, $user_id)
    {
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

        $depf = ExamCadry::where('management_id', $manag_id)
            ->where('organization_id', $org_id)
            ->where('year_exam', $year_exam)
            ->where('year_quarter', $month_exam)
            ->where('user_id', $user_id)
            ->select('department_id')->groupBy('department_id')->pluck('department_id')->toArray();

        $departments = Department::whereIn('id', $depf)->get();
        $a = [];
        foreach($departments as $item) {
            $q = ExamCadry::where('management_id', $manag_id)
                    ->where('organization_id', $org_id)
                    ->where('year_exam', $year_exam)
                    ->where('year_quarter', $month_exam)
                    ->where('user_id', $user_id)
                    ->where('department_id', $item->id)
                    ->where('ball', '!=', 0);
            
            if($q->count() >= 1)
                $koef = $q->sum('ball')/$q->count(); else $koef = 0;

            $a[] = [
                'id' => $item->id,
                'name' => $item->name,
                'ball' => $koef
            ];
        }
        $org_name = Organization::find($org_id)->name;
        $manag_name = Management::find($manag_id)->name;
        $user_name = User::find($user_id)->name;

        return view('backpack::exam_teacher_deps', [
            'title' => trans('backpack::base.statistics'),
            'a' => $a,
            'org_name' => $org_name,
            'manag_name' => $manag_name,
            'org_id' => $org_id,
            'manag_id' => $manag_id,
            'user_name' => $user_name,
            'user_id' => $user_id
        ]);

    }


       
    public function exam_teacher_dep_positions($org_id, $manag_id, $user_id, $dep_id)
    {
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

        $posf = ExamCadry::where('management_id', $manag_id)
            ->where('organization_id', $org_id)
            ->where('year_exam', $year_exam)
            ->where('year_quarter', $month_exam)
            ->where('user_id', $user_id)
            ->where('department_id', $dep_id)
            ->select('position_id')->groupBy('position_id')->pluck('position_id')->toArray();

        $positions = Position::whereIn('id', $posf)->get();
        
        $a = [];
        foreach($positions as $item) {

            $q = ExamCadry::where('management_id', $manag_id)
                    ->where('organization_id', $org_id)
                    ->where('year_exam', $year_exam)
                    ->where('year_quarter', $month_exam)
                    ->where('user_id', $user_id)
                    ->where('department_id', $dep_id)
                    ->where('position_id', $item->id)
                    ->where('ball', '!=', 0);
            
            if($q->count() >= 1)
                $koef = $q->sum('ball')/$q->count(); else $koef = 0;

            $a[] = [
                'id' => $item->id,
                'name' => $item->name,
                'ball' => $koef
            ];
        }
        $org_name = Organization::find($org_id)->name;
        $manag_name = Management::find($manag_id)->name;
        $user_name = User::find($user_id)->name;
        $dep_name = Department::find($dep_id)->name;

        return view('backpack::exam_teacher_dep_positions', [
            'title' => trans('backpack::base.statistics'),
            'a' => $a,
            'org_name' => $org_name,
            'manag_name' => $manag_name,
            'org_id' => $org_id,
            'manag_id' => $manag_id,
            'user_name' => $user_name,
            'dep_name' => $dep_name,
            'dep_id' => $dep_id,
            'user_id' => $user_id
        ]);

    }

    public function exam_teacher_dep_position_cadries($org_id, $manag_id, $user_id, $dep_id, $pos_id)
    {
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

        $cadryf = ExamCadry::where('management_id', $manag_id)
            ->where('organization_id', $org_id)
            ->where('year_exam', $year_exam)
            ->where('year_quarter', $month_exam)
            ->where('user_id', $user_id)
            ->where('department_id', $dep_id)
            ->where('position_id', $pos_id)
            ->select('cadry_id')->groupBy('cadry_id')->pluck('cadry_id')->toArray();

        $cadries = Cadry::whereIn('id', $cadryf)->get();
        
        $a = [];
        foreach($cadries as $item) {

            $q = ExamCadry::where('management_id', $manag_id)
                    ->where('organization_id', $org_id)
                    ->where('year_exam', $year_exam)
                    ->where('year_quarter', $month_exam)
                    ->where('user_id', $user_id)
                    ->where('department_id', $dep_id)
                    ->where('position_id', $pos_id)
                    ->where('cadry_id', $item->id)
                    ->where('ball', '!=', 0);
            
            if($q->count() >= 1)
                $koef = $q->sum('ball')/$q->count(); else $koef = 0;

            $a[] = [
                'id' => $item->id,
                'name' => $item->fullname,
                'ball' => $koef
            ];
        }
        $org_name = Organization::find($org_id)->name;
        $manag_name = Management::find($manag_id)->name;
        $user_name = User::find($user_id)->name;
        $dep_name = Department::find($dep_id)->name;
        $pos_name = Position::find($pos_id)->name;

        return view('backpack::exam_teacher_dep_position_cadries', [
            'title' => trans('backpack::base.statistics'),
            'a' => $a,
            'org_name' => $org_name,
            'manag_name' => $manag_name,
            'org_id' => $org_id,
            'manag_id' => $manag_id,
            'user_name' => $user_name,
            'dep_name' => $dep_name,
            'dep_id' => $dep_id,
            'user_id' => $user_id,
            'pos_id' => $pos_id,
            'pos_name' => $pos_name
        ]);

    }

    public function tec()
    {
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
        $userorgs = UserOrganization::where('organization_id', $org_id)->pluck('user_id')->toArray();
        
        $users = User::whereIn('id', $userorgs)->whereHas(
            'roles', function($q){
                $q->where('name', 'teacher_theme');
            })->get();
        
        $a = [];
        foreach($users as $item) {
            $q = ExamCadry::where('management_id', $manag_id)
                    ->where('organization_id', $org_id)
                    ->where('year_exam', $year_exam)
                    ->where('year_quarter', $month_exam)
                    ->where('user_id', $item->id)
                    ->where('ball', '!=', 0);
            
            if($q->count() >= 1)
            {
                $z = $q->sum('ball')/$q->count();
                $koef= number_format($z, 2, ',', '');
            } else $koef = 0;

            $a[] = [
                'id' => $item->id,
                'name' => $item->name,
                'ball' => $koef
            ];
        }

        $exam_cadries = ExamCadry::where('management_id', $manag_id)
                    ->where('organization_id', $org_id)
                    ->where('year_exam', $year_exam)
                    ->where('year_quarter', $month_exam)
                    ->where('ball', '!=', 0);

        $org_name = Organization::find($org_id)->name;
        $manag_name = Management::find($manag_id)->name;

        return view('backpack::exam_statistics', [
            'title' => trans('backpack::base.statistics'),
            'a' => $a,
            'org_name' => $org_name,
            'manag_name' => $manag_name,
            'org_id' => $org_id,
            'manag_id' => $manag_id,
            'exam_cadries' => $exam_cadries->paginate(10)
        ]);

    }
}
