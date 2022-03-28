<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Adds extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'name_en', 'status', 'body', 'body_en', 'user_id', 'image'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function name()
    {
        if (App::getLocale() == 'ar') {
            $name = $this->name;
        } else {
            $name = $this->name_en;
        }
        return $name;
    }
    public function body()
    {
        if (App::getLocale() == 'ar') {
            $body = $this->body;
        } else {
            $body = $this->body_en;
        }
        return $body;
    }
}
