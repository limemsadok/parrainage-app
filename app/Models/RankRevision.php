<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RankRevision extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'advisor_id',
        'old_rank_id',
        'new_rank_id',
        'amount',
    ];

    public function advisor(){
        return $this->HasOne(Advisor::class,"id",'advisor_id');
    }
}
