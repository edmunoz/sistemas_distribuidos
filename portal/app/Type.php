<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'types';

    /**
     * Primary key for the table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
}
