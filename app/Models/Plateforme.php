<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plateforme extends Model
{
    protected $fillable = ['name'];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_platform', 'platform_id', 'item_id');
    }
}
