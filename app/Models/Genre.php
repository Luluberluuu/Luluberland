<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $fillable = ['name'];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_genre', 'genre_id', 'item_id');
    }
}
