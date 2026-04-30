<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'service_id',
        'employee_id',
        'user_id',
        'name',
        'phone',
        'date',
        'time',
        'total_price',
        'booking_code',
        'status'
    ];

    // Relasi ke Service
    public function service() {
        return $this->belongsTo(Service::class);
    }

    // Relasi ke Employee
    public function employee() {
        return $this->belongsTo(Employee::class);
    }

    // Relasi ke User (pelanggan)
    public function user() {
        return $this->belongsTo(User::class);
    }
}