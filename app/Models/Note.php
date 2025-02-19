<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'user_id'];

    public function remarks()
    {
        return $this->hasMany(Remark::class);
    }
}
