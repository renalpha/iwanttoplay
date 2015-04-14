<?php

use Illuminate\Database\Eloquent\Model;
use LaravelBook\Ardent\Ardent;


class Playlist extends Ardent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'playlists';
    protected $fillable = array('group_id','name','created_at', 'updated_at');


    public function Group()
    {
        return $this->belongsTo('GroupName', 'group_id');
    }

    public function tracks()
    {
        return $this->hasMany('Track');
    }

}
