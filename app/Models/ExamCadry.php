<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamCadry extends Model
{
    use HasFactory;

    public function cadry()
    {
        return $this->belongsTo(Cadry::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function management()
    {
        return $this->belongsTo(Management::class);
    }

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    public function exams()
    {
        return $this->hasMany(ExamCadry::class,'cadry_id', 'cadry_id');
    }

   
}
