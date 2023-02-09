<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Theme extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'themes';
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

    public function cadries($crud = false)
    {
        return view('vendor.backpack.crud.buttons.cadries_theme', [
            'id' => $this->id
        ]);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function railway()
    {
        return $this->belongsTo(Railway::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
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
