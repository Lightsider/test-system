<?php

namespace App;

use Docker\API\Model\ContainersCreatePostBody;
use Docker\Docker;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_user
 * @property int $id_test
 * @property int $id_current_quest
 * @property string $quest_arr
 * @property string $skip_quest_arr
 * @property string $endtime
 * @property string $created_at
 * @property string $updated_at
 * @property Quests $question
 * @property Tests $test
 * @property Users $user
 */
class TempTesting extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'temp_testing';

    /**
     * @var array
     */
    protected $fillable = ['id_user', 'id_test', 'id_current_quest', 'quest_arr', 'skip_quest_arr', 'endtime', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo('App\Quests', 'id_current_quest');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function test()
    {
        return $this->belongsTo('App\Tests', 'id_test');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Users', 'id_user');
    }

    /**
     * @return mixed
     */
    public function getCurrentUserCount()
    {
        return TempTesting::where("id_test",$this->id_test)->count();
    }

    /**
     * @return mixed
     */
    public function getCompleteUserCount()
    {
        return Results::where("id_test",$this->id_test)->where("date",date("Y-m-d"))->count();
    }
}
