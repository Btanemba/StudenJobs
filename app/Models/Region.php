<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
        'remark',
    ];

    protected $casts = [
    'created_by' => 'integer',
    'updated_by' => 'integer'
];

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
}
