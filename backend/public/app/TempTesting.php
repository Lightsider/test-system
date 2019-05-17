<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
    public function quest()
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
    public function getQuestArrAttribute($quest_arr)
    {
        return json_decode($quest_arr);
    }

    /**
     * @return mixed
     */
    public function getSkipQuestArrAttribute($skip_quest_arr)
    {
        return json_decode($skip_quest_arr);
    }

    /**
     * @return bool
     */
    public function isTestingProcessing()
    {
        if (empty($this) || !$this->checkTestingIsNotEnd()) return false;

        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    private function checkTestingIsNotEnd()
    {
        $endTimeStamp = strtotime($this->endtime);
        if($endTimeStamp <= time())return false;

        return true;
    }

    /**
     * @return false|string
     */
    private function getStartTime()
    {
        $data_array = date_parse($this->test->time);
        return date("H:i:s", strtotime($this->endtime) - strtotime("-" . $data_array["hour"] . " hours -" . $data_array["minute"] . "minutes -" .
            $data_array["second"] . " seconds"));
    }

    public function stopTesting()
    {
        DB::transaction(function () {
            $result = new Results();
            $result->id_user = $this->id_user;
            $result->id_test = $this->id_test;
            $result->date = date("Y-m-d", time());
            $result->time = date("H:i:s", time() - strtotime($this->getStartTime()));
            if (strtotime($this->getStartTime()) + strtotime($result->time) > strtotime($this->endtime)) $result->time = $this->test->time;

            $resultObj = $this->quest_arr;
            $resultScore = 0;
            $countQuest = 0;
            $maxScore = $this->test->getMaxScore();
            foreach ($resultObj as $answer) {
                $countQuest++;
                if ($answer->answered == "1") $resultScore += $answer->score;
            }
            $result->result = round($resultScore / $maxScore * 100, 2);
            $result->save();

            $this->delete();
        });
    }
}
