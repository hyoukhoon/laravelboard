<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memos extends Model
{
    use HasFactory;

    protected $fillable = [
        'bid','pid','userid','username','memo','code'
    ];
}
