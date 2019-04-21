<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_quest
 * @property string $path
 * @property string $created_at
 * @property string $updated_at
 * @property Question $question
 */
class Files extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_quest', 'path', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo('App\Question', 'id_quest');
    }
}
