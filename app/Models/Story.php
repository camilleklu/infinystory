<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Story extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'summary',
        'prompt',
        'body',
        'user_id',
        'status',
    ];

    public function user()
    {
        // Une histoire "appartient à" un utilisateur
        return $this->belongsTo(User::class);
    }

    public function chapters()
    {
        // Une histoire "a plusieurs" chapitres
        return $this->hasMany(Chapter::class)->orderBy('order', 'asc');
    }

    public function getExcerptAttribute()
    {
        return Str::limit($this->summary ?: $this->body, 150);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
