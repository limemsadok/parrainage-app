<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvisorTree extends Model
{
    protected $table = 'advisors_tree';

    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'advisor_id',
        'child_id',
        'direct',
    ];
    /**
     * Get the advisor for the advisor tree or child.
     */
    public function advisor()
    {
        return $this->belongsTo(advisor::class);
    }

    public function getTeamScoreChild()
    {
        return $this->hasOne(TeamScore::class,"advisor_id","child_id");
    }

    public function getPersoScore()
    {
        return $this->hasOne(PersonalScore::class,"advisor_id","advisor_id");
    }
}
