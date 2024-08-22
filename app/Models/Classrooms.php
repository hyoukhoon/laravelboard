<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classrooms extends Model
{
	use HasFactory;
	protected $fillable = [
        'userid','subject','contents','memo_cnt','memo_date','tags','shorts','cate'
    ];
}
