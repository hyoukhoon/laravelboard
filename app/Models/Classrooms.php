<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classrooms extends Model
{
	use HasFactory;
	protected $fillable = [
        'userid','contents','memo_cnt','memo_date'
    ];
}
