<?php

namespace App\Http\Controllers\Admin;

use App\Models\ExamCadry;
use App\Models\Organization;
use App\Models\Management;
use App\Models\Examination;

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
            ->orderBy('ball','desc')->with(['exams'])->paginate(10);

        $organizations = Organization::get();
        $managements = Management::get();
        
        return view('backpack::exam_statistics', [
            'exam_cadries' => $exam_cadries,
            'organizations' => $organizations,
            'managements' => $managements,
        ]);
    }
}
