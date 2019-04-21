<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $time
 * @property string $created_at
 * @property string $updated_at
 */
class Tests extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tests';

    /**
     * @var array
     */
    protected $fillable = ['title', 'description', 'time', 'created_at', 'updated_at'];

}
