<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = ['name', 'image', 'chairman', 'vice_chairman', 'vision', 'mission', 'sort_order'];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
