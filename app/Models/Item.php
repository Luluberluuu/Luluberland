<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['title', 'type', 'api_id', 'poster', 'release_date', 'overview', 'rating_api'];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'item_genre', 'item_id', 'genre_id');
    }

    public function plateformes()
    {
        return $this->belongsToMany(Plateforme::class, 'item_platform', 'item_id', 'platform_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_items', 'item_id', 'user_id')
                    ->withPivot('status', 'rating', 'review')
                    ->withTimestamps();
    }
}
