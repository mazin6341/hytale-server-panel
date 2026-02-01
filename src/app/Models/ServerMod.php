<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServerMod extends Model
{
    protected $fillable = [
        'curse_id', 
        'name', 
        'slug', 
        'author_name', 
        'summary', 
        'thumbnail_url', 
        'file_name', 
        'version', 
        'mod_url'
    ];

    public function isCurseforge(): bool {
        return !empty($this->curse_id);
    }
}