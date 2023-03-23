<?php

namespace App\Http\Controllers\Admin;

use App\Models\ExamCadry;
use App\Models\Organization;
use App\Models\Management;
use App\Models\Examination;
use App\Models\CheckCadry;

use Illuminate\Http\Request;

class ExaminationController
{
    public function exam_statistics(Request $request)
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
            ->orderBy('ball','desc')->with(['exams']);

            if(request('status_order')) {
                if(request('year_exam')&&request('year_quarter')) {
                   

                    if(request('status_order') == 1)
                    
                    $exam_cadries = $exam_cadries->whereHas('exams', function($q) {
                        $year_exam = request('year_exam');
                        $year_quarter = request('year_quarter');
                        if($year_quarter == 1) {
                            $year_exam = $year_exam - 1;
                            $year_quarter = 4;
                        } else 
                         $year_quarter = $year_quarter - 1;

                        $q->where('year_exam', $year_exam)
                            ->where('year_quarter', $year_quarter)
                            ->where('ball','>', 56);
                    });

                    else if(request('status_order') == 2)
                    $exam_cadries = $exam_cadries->whereHas('exams', function($q) {
                        $year_exam = request('year_exam');
                        $year_quarter = request('year_quarter');
                        if($year_quarter == 1) {
                            $year_exam = $year_exam - 1;
                            $year_quarter = 4;
                        } else 
                         $year_quarter = $year_quarter - 1;

                        $q->where('year_exam', $year_exam)
                            ->where('year_quarter', $year_quarter)
                            ->where('ball','<', 56);
                    });
                }
            }

        $organizations = Organization::get();
        $managements = Management::get();
        
        return view('backpack::exam_statistics', [
            'exam_cadries' => $exam_cadries->paginate(10),
            'organizations' => $organizations,
            'managements' => $managements,
        ]);
    }

    public function exam_themes(Request $request)
    {

        $exam_cadries = CheckCadry::query()
            ->when(request('org_id'), function ( $query, $org_id) {
                return $query->where('organization_id', $org_id);

            })
            ->when(request('year_theme'), function ( $query, $year_theme) {
                return $query->whereYear('date_theme', $year_theme);

            })
            ->when(request('month_theme'), function ( $query, $month_theme) {
                return $query->whereMonth('date_theme', $month_theme);

            })
            ->where('status',false)->paginate(10);

        $organizations = Organization::get();
        $managements = Management::get();
        
        return view('backpack::exam_themes', [
            'exam_cadries' => $exam_cadries,
            'organizations' => $organizations,
            'managements' => $managements,
        ]);
    }
}
