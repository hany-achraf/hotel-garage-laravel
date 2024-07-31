<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'qr_code',
        'plate_no',
        'email',
        'phone_no',
        'entry_guard_id',
        'entry_gate_id',
        'entry_time',
        'exit_guard_id',
        'exit_gate_id',
        'exit_time',
    ];

    protected $casts = [
        'entry_time' => 'datetime',
        'exit_time' => 'datetime',
    ];

    public function entryGuard()
    {
        return $this->belongsTo(User::class, 'entry_guard_id');
    }

    public function entryGate()
    {
        return $this->belongsTo(Gate::class, 'entry_gate_id');
    }

    public function exitGuard()
    {
        return $this->belongsTo(User::class, 'exit_guard_id');
    }

    public function exitGate()
    {
        return $this->belongsTo(Gate::class, 'exit_gate_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getIsPaidAttribute()
    {
        $isPaid = false;

        $this->transactions->each(function ($transaction) use (&$isPaid) {
            if ($transaction->created_at->diffInMinutes(now()) <= 20) {
                $isPaid = true;
                return;
            }
        });

        return $isPaid;
    }
}
