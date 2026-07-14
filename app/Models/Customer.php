<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'notes',
    ];

    // Convenience accessor: $customer->full_name
    protected function fullName(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn () => "{$this->first_name} {$this->last_name}",
        );
    }

    // Will be used once Appointments exist (Milestone 5)
    // public function appointments()
    // {
    //     return $this->hasMany(Appointment::class);
    // }
}
