<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = "post";

    protected $fillable = [
        'title',
        'content',
    ];

    protected $hidden = [
        'idUser',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'idPost', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'id');
    }
}
