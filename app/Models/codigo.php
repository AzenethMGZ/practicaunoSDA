<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class codigo extends Model
{
    use HasFactory;
    protected $fillable=[
        'codigo',
        'id_user',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
