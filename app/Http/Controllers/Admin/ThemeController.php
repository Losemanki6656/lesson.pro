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

        $cadries = Cadry::where('management_id', 2)->get();

        foreach($cadries as $item)
        {
            $item->organization_id = 16;
            $item->save();
        }

        
        return redirect()->back();
    }

}
