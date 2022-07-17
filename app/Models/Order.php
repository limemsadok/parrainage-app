<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\advisor;

class Order extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'advisor_id',
        'parent_id',
        'parent_rank',
        'advisor_rank',
        'total_value',
        'paid',
        'paid_at',
        'fo',
    ];
    /**
     * Get the advisor for the order.
     */
    public function advisor()
    {
        return $this->belongsTo(advisor::class);
    }
}
