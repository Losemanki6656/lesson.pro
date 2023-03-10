<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Examination extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'examinations';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    // protected static function boot()
    // {
    //     parent::boot();

    //     if (Auth::check() && Auth::user()->userorganization) {
    //         $companyId = Auth::user()->userorganization->organization_id;

    //         static::addGlobalScope('organization_id', function ($builder) use ($companyId) {
    //             $builder->where('organization_id', $companyId);
    //         });
    //     }
    // }


    public function position()
    {
        return $this->cadry->fullname;
    }

    public function cadries($crud = false)
    {
        return view('vendor.backpack.crud.buttons.cadries', [
            'id' => $this->id
        ]);
    }

    public function cadry()
    {
        return $this->belongsTo(Cadry::class);
    }

    public function exams()
    {
        return $this->hasMany(ExamCadry::class);
    }
  
    public function getExamsCountAttribute($value)
    {
        return $this->exams()->count();
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
