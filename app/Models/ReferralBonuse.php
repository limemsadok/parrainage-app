<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralBonuse extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'advisor_id',
        'order_id',
        'amount',
    ];
}
