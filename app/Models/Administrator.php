<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Administrator extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'administrators';
    protected $guarded = ['id'];

    protected $fillable = ['id', 'remark', 'created_by', 'updated_by'];
    public $incrementing = false;

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
