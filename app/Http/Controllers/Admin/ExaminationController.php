<?php

namespace App\Http\Controllers\Admin;

use App\Models\ExamCadry;
use App\Models\Organization;
use App\Models\Management;

use Illuminate\Http\Request;

class ExaminationController
{
    public function exam_statistics(Request $request)
    {
        
        $exam_cadries = ExamCadry::orderBy('ball','desc')->with(['exams'])->get();
        $organizations = Organization::get();
        $managements = Management::get();
        
        return view('backpack::exam_statistics', [
            'exam_cadries' => $exam_cadries,
            'organizations' => $organizations,
            'managements' => $managements,
        ]);
    }
}
