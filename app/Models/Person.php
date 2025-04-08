<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use CrudTrait;
    // Specify the table name if it differs from the default 'persons'
    protected $table = 'persons';

    // Allow mass assignment for the fields
    protected $fillable = [
        'first_name', 'last_name', 'gender', 'street', 'number', 'city', 'zip', 'region', 'country',
        'phone', 'remark', 'university_name', 'university_address', 'start_year', 'finish_year',
        'student_id_picture_front', 'student_id_picture_back', 'user_id'
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setStudentIdPictureFrontAttribute($value)
{
    $this->attributes['student_id_picture_front'] = $value->store('uploads', 'public');
}

public function setStudentIdPictureBackAttribute($value)
{
    $this->attributes['student_id_picture_back'] = $value->store('uploads', 'public');
}

}
