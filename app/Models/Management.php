<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Management extends Model
{
    use HasFactory;

    public function exam_cadries()
    {
        return $this->hasMany(ExamCadry::class);
    }
}
