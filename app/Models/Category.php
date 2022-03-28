<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'status', 'name_en', 'user_id', 'image'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function incomes()
    {
        return $this->hasMany(Income::class);
    }
    public function name()
    {
        if (App::getLocale() == 'ar') {
            return $this->name;
        } else {
            return $this->name_en;
        }
    }
}
