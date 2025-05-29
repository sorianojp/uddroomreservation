<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['room', 'purpose', 'end_at', 'start_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
