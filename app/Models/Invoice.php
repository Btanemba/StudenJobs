<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use CrudTrait;

    protected $fillable = [
        'person_id', 'invoice_number', 'invoice_date', 'due_date', 'total', 'status', 'invoice_file'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
    public function setInvoiceFileAttribute($value)
    {
        if ($value) {
            $fileName = 'invoice_' . time() . '_' . $value->getClientOriginalName();
            $this->attributes['invoice_file'] = $value->storeAs('invoices', $fileName, 'public');
        }
    }

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

    protected static function boot()
{
    parent::boot();

    static::creating(function($model) {
        $model->created_by = backpack_auth()->id();
    });

    static::updating(function($model) {
        $model->updated_by = backpack_auth()->id();
    });
}

}
