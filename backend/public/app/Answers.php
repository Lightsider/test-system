<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_quest
 * @property string $text
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property Quests $question
 */
class Answers extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_quest', 'text', 'status', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo('App\Quests', 'id_quest');
    }
}
