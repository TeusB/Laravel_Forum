<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    use HasFactory;
    protected $table = "comment";

    protected $fillable = [
        'title',
        'content',
        'idPost',
    ];

    protected $hidden = [
        'idUser'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'idPost', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'id');
    }
}
