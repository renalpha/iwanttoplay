<?php

use Illuminate\Database\Eloquent\Model;
use LaravelBook\Ardent\Ardent;


class Track extends Ardent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tracks';
    protected $fillable = array('title','artist','playlist_id','url','type','created_at', 'updated_at');


    public function Playlist()
    {
        return $this->belongsTo('Playlist', 'id');
    }

}
