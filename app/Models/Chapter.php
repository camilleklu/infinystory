<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{

    protected $fillable = ['story_id', 'title', 'body', 'order'];
    public function story()
    {
        // Un chapitre "appartient à" une histoire
        return $this->belongsTo(Story::class);
    }
}
