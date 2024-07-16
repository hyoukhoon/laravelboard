<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int      $num
 * @property int      $bad
 * @property int      $cnt
 * @property int      $good
 * @property int      $isdisp
 * @property int      $isimg
 * @property int      $level
 * @property int      $memo_cnt
 * @property int      $notice
 * @property int      $notviewmemo
 * @property int      $pnum
 * @property int      $step
 * @property string   $attachfile
 * @property string   $cate
 * @property string   $content
 * @property string   $email
 * @property string   $file_list
 * @property string   $fn_name1
 * @property string   $fn_name2
 * @property string   $gubun
 * @property string   $ip
 * @property string   $mobile
 * @property string   $multi
 * @property string   $name
 * @property string   $passwd
 * @property string   $subject
 * @property string   $thumb
 * @property string   $uid
 * @property string   $url
 * @property string   $videourl
 * @property DateTime $edit_date
 * @property DateTime $memo_date
 * @property DateTime $reg_date
 * @property boolean  $iswarning
 */
class Cboard extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cboard';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'num';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'attachfile', 'bad', 'cate', 'cnt', 'content', 'edit_date', 'email', 'file_list', 'fn_name1', 'fn_name2', 'good', 'gubun', 'html', 'ip', 'isdisp', 'isimg', 'iswarning', 'level', 'memo_cnt', 'memo_date', 'mobile', 'multi', 'name', 'notice', 'notviewmemo', 'passwd', 'pnum', 'point', 'reg_date', 'scrap_cnt', 'secret', 'step', 'subject', 'thumb', 'uid', 'url', 'videourl'
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
        'num' => 'int', 'attachfile' => 'string', 'bad' => 'int', 'cate' => 'string', 'cnt' => 'int', 'content' => 'string', 'edit_date' => 'datetime', 'email' => 'string', 'file_list' => 'string', 'fn_name1' => 'string', 'fn_name2' => 'string', 'good' => 'int', 'gubun' => 'string', 'ip' => 'string', 'isdisp' => 'int', 'isimg' => 'int', 'iswarning' => 'boolean', 'level' => 'int', 'memo_cnt' => 'int', 'memo_date' => 'datetime', 'mobile' => 'string', 'multi' => 'string', 'name' => 'string', 'notice' => 'int', 'notviewmemo' => 'int', 'passwd' => 'string', 'pnum' => 'int', 'reg_date' => 'datetime', 'step' => 'int', 'subject' => 'string', 'thumb' => 'string', 'uid' => 'string', 'url' => 'string', 'videourl' => 'string'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'edit_date', 'memo_date', 'reg_date'
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
