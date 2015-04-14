<?php

use Illuminate\Database\Eloquent\Model;
use LaravelBook\Ardent\Ardent;


class Tester extends Ardent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'test';
    protected $fillable = array('id','val');
    public $timestamps = false;


}
