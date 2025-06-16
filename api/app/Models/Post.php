<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = ['title', 'content', 'author_id'];
    protected $hidden = ['created_at', 'updated_at'];
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
