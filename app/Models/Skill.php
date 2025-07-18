<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'skill_name',
        'user_id',
        'years_of_experience',
        'price',
        'description',
        'skill_level',
        'certification',
        'sample_pictures',
        'sample_videos',
        'created_by',
        'updated_by',
    ];

 protected $casts = [
        'sample_pictures' => 'array',
        'sample_videos' => 'array',
    ];

public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by')->with('person');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by')->with('person');
    }





}
