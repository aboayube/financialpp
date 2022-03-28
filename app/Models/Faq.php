<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'title_en', 'status', 'body_en', 'body', 'id', 'user_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
