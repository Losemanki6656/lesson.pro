<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Cadry extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'cadries';
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

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }


    public function text_html()
    {
        return str_replace("\n", "<br>", $this->fullname);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function education()
    {
        return $this->belongsTo(Education::class);
    }

    public function scopeFilter()
    {
        return self::query()
            ->where('organization_id', backpack_user()->userorganization->organization_id)
            ->where('status',true);
    }

    public function scopeRailwayFilter()
    {
        return self::query()
            ->where('status',true)
            ->when(request('organization_id'), function ( $query, $organization_id) {
                return $query->where('organization_id', $organization_id);

            });
    }

    public function scopeOrgFilter()
    {
        return self::where('status',true)->where('organization_id', backpack_user()->userorganization->organization_id);
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
