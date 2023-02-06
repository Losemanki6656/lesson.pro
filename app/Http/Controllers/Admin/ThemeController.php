<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Theme;
use App\Models\ExamCadry;
use App\Models\Cadry;
use App\Models\Management;
use App\Models\OrganizationManagement;

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
        $cadries = Cadry::all();
        foreach($cadries as $item)
        {
           $man =  OrganizationManagement::where('organization_id', $item->organization_id)->first();
            $item->management_id = $man->management_id;
            $item->save();
        }

        
        return redirect()->back();
    }

}
