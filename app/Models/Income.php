<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;
    protected $fillable = [
        'type_name',
        'type_expense',
        'category_id',
        'amount',
        'duration',
        'bank_id',
        'date',
        'time',
        'Note',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
}
