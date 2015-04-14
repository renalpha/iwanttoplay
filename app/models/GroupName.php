<?php

use Illuminate\Database\Eloquent\Model;
use LaravelBook\Ardent\Ardent;


class GroupName extends Ardent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'groups';
    protected $fillable = array('name','slug','permissions', 'created_at', 'updated_at');


    public function UserGroup()
    {
        return $this->belongsTo('UserGroup', 'group_id');
    }

    public function Playlist()
    {
        return $this->hasMany('Playlist', 'group_id');
    }

}
