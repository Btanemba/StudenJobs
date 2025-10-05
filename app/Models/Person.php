<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Person extends Model
{
    use CrudTrait;

    // Specify the table name if it differs from the default 'persons'
    protected $table = 'persons';

    // Allow mass assignment for the fields
    protected $fillable = [
        'first_name', 'last_name', 'gender', 'street', 'number', 'city', 'zip', 'region', 'country',
        'phone', 'remark', 'university_name', 'university_address', 'start_year', 'finish_year',
        'student_id_picture_front', 'student_id_picture_back', 'user_id', 'payment_plan',
        'profile_picture','valid_till', 'created_by',
        'updated_by','preferred_contact_method',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoices()
{
    return $this->hasMany(Invoice::class);
}

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by')->with('person');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by')->with('person');
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    /**
     * Accessors for full name
     */
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
     * Mutators for file uploads
     */
    public function setStudentIdPictureFrontAttribute($value)
    {
        if ($value) {
            $this->attributes['student_id_picture_front'] = $value->store('student_ids', 'public');
        }
    }

    public function setStudentIdPictureBackAttribute($value)
    {
        if ($value) {
            $this->attributes['student_id_picture_back'] = $value->store('student_ids', 'public');
        }
    }

    public function setProfilePictureAttribute($value)
    {
        if ($value) {
            $originalName = $value->getClientOriginalName();
            $this->attributes['profile_picture'] = $value->storeAs('profile_pictures', $originalName, 'public');
        }
    }
}
