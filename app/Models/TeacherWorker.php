<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Auth;

class TeacherWorker extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'teacher_workers';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    public function teachers()
    {
        return $this->hasMany(Cadry::class, 'teacher_id');
    }

    public function workers()
    {
        return $this->hasMany(Cadry::class, 'worker_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Cadry::class, 'teacher_id');
    }

    public function worker()
    {
        return $this->belongsTo(Cadry::class, 'worker_id');
    }

    protected static function boot()
    {
        parent::boot();

        if (Auth::check() && Auth::user()->userorganization) {
            $companyId = Auth::user()->userorganization->organization_id;

            static::addGlobalScope('organization_id', function ($builder) use ($companyId) {
                $builder->where('organization_id', $companyId);
            });
        }
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
