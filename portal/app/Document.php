<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'documents';

    /**
     * Primary key for the table associated with the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';


}
