<?php

namespace App\Models;

use App\Models\order;
use App\Models\advisorTree;
use App\Models\PersonalScore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Advisor extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rank_id',
        'parent_id',
        'login',
    ];
    /**
     * Get the child for the advisor tree.
     */
    public function childs()
    {
        return $this->hasMany(Advisor::class,"parent_id");
    }
    /**
     * Get the child for the advisor tree.
     */
    public function advisorTree()
    {
        return $this->hasMany(advisorTree::class,"advisor_id","id");
    }
    /**
     * Get the orders for the advisor.
     */
    public function advisorOrders()
    {
        return $this->hasMany(order::class);
    }
    /**
     * Get the amount associated with the advisor.
     */
    public function amount()
    {
        return $this->hasOne(PersonalScore::class);
    }
    /**
     * Get the amount associated with the advisor.
     */
    public function teamScore()
    {
        return $this->hasOne(TeamScore::class);
    }


    public function childAmount()
    {
        return $this->hasManyThrough(
            PersonalScore::class,
            advisorTree::class,
            'advisor_id', // Foreign key on the advisor_tree table...
            'advisor_id', // Foreign key on the personal_score table...
            'id', // Local key on the advisor table...
            'child_id' // Local key on the advisor_tree table...
        );
    }
}
