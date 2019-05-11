<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_quest
 * @property int $id_test
 * @property string $created_at
 * @property string $updated_at
 * @property Quests $question
 * @property Tests $test
 */
class TestToQuest extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'test_to_quest';

    /**
     * @var array
     */
    protected $fillable = ['id_quest', 'id_test', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo('App\Quests', 'id_quest');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function test()
    {
        return $this->belongsTo('App\Tests', 'id_test');
    }
}
