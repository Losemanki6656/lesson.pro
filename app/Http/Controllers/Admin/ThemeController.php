<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Theme;

class ThemeController
{
    
    public function themes()
    {

        $themes = Theme::query()->paginate(10);
        
        return view('backpack::themes', [
            'themes' => $themes
        ]);
    }

}
