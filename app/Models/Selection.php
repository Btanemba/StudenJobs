<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Selection extends Model
{
    use CrudTrait;
    protected $fillable = ['table', 'field', 'code', 'name','order'];


    /**
     * Relationships
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by')->with('person');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by')->with('person');
    }

    /**
     * Accessors for full name
     */

    protected $appends = ['created_by_name', 'updated_by_name'];

    public function getCreatedByNameAttribute()
    {
        return $this->creator && $this->creator->person
            ? $this->creator->person->first_name . ' ' . $this->creator->person->last_name
            : 'N/A';
    }

    public function getUpdatedByNameAttribute()
    {
        return $this->updater && $this->updater->person
            ? $this->updater->person->first_name . ' ' . $this->updater->person->last_name
            : 'N/A';
    }

    /**
     * Boot the model and register event hooks.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($status) {
            if (Auth::check()) {
                $status->created_by = Auth::id();
                $status->updated_by = Auth::id();
            }
        });

        static::updating(function ($status) {
            if (Auth::check()) {
                $status->updated_by = Auth::id();
            }
        });
    }
}


