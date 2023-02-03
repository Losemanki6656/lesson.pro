<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Theme;
use App\Models\ExamCadry;
use App\Models\Cadry;

class ThemeController
{
    
    public function themes()
    {

        $themes = Theme::query()->paginate(10);
        
        return view('backpack::themes', [
            'themes' => $themes
        ]);
    }

    public function control()
    {

        $cadries = ExamCadry::get();

        foreach($cadries as $item)
        {
            $cadry = Cadry::find($item->cadry_id);
            $item->department_id = $cadry->department_id;
            $item->position_id = $cadry->position_id;
            $item->user_id = backpack_user()->id;
            $item->save();
        }

        
        return back();
    }

}
