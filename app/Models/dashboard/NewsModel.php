<?php

namespace App\Models\dashboard;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class NewsModel extends Model
{

    protected $fillable = [
        'author_id',
        'title',
        'shortDescription',
        'description',

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
