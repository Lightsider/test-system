<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_quest
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property Quests $question
 */
class DockerContainers extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_quest', 'name', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo('App\Question', 'id_quest');
    }
}
