<?php

use Illuminate\Database\Eloquent\Model;
use LaravelBook\Ardent\Ardent;


class UserGroup extends Ardent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_groups';
    protected $fillable = array('user_id','group_id');
    public $timestamps = false;


    public function user()
    {
        return $this->belongsTo('User', 'id');
    }

    public function groupname()
    {
        return $this->hasOne('GroupName');
    }

}
