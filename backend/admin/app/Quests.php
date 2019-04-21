<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class Quests extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'Questions';

    /**
     * @var array
     */
    protected $fillable = ['title', 'description', 'created_at', 'updated_at'];

}
