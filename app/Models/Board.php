<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int      $bid
 * @property int      $bid
 * @property int      $parent_id
 * @property int      $status
 * @property int      $parent_id
 * @property string   $content
 * @property string   $multi
 * @property string   $subject
 * @property string   $username
 * @property string   $content
 * @property string   $multi
 * @property string   $subject
 * @property string   $username
 * @property DateTime $modifydate
 * @property DateTime $regdate
 * @property DateTime $modifydate
 * @property DateTime $regdate
 * @property boolean  $status
 */
class Board extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'board';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'bid';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'multi', 'subject', 'username', 'cnt', 'status', 'attachfiles', 'memo_cnt', 'memo_date'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'bid' => 'int', 'content' => 'string', 'modifydate' => 'datetime', 'multi' => 'string', 'parent_id' => 'int', 'regdate' => 'datetime', 'status' => 'int', 'subject' => 'string', 'username' => 'string', 'content' => 'string', 'modifydate' => 'datetime', 'multi' => 'string', 'parent_id' => 'int', 'regdate' => 'datetime', 'status' => 'boolean', 'subject' => 'string', 'username' => 'string'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'modifydate', 'regdate', 'modifydate', 'regdate'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;

    // Scopes...

    // Functions ...

    // Relations ...
}
