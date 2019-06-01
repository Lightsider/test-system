<?php

namespace App;

use Docker\API\Model\ContainersCreatePostBody;
use Docker\API\Model\HostConfig;
use Docker\API\Model\PortBinding;
use Docker\Docker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

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
        if ($endTimeStamp <= time()) return false;

        return true;
    }

    /**
     * @return false|string
     */
    public function getStartTime()
    {
        $data_array = date_parse($this->test->time);
        return date("H:i:s", strtotime($this->endtime . " -" . $data_array["hour"] . " hours -" . $data_array["minute"] . "minutes -" .
            $data_array["second"] . " seconds"));
    }

    /**
     *
     */
    public function stopTesting()
    {
        DB::transaction(function () {
            $result = new Results();
            $result->id_user = $this->id_user;
            $result->id_test = $this->id_test;
            $result->date = date("Y-m-d", time());
            $data_array = date_parse($this->getStartTime());
            $result->time = date("H:i:s", strtotime(date("Y-m-d H:i:s") . " -" . $data_array["hour"] . " hours -" . $data_array["minute"] . "minutes -" .
                $data_array["second"] . " seconds"));
            //if (strtotime($this->getStartTime()) + strtotime($result->time) > strtotime($this->endtime)) $result->time = $this->test->time;

            $resultObj = $this->quest_arr;
            $resultScore = 0;
            $countQuest = 0;
            $maxScore = $this->test->getMaxScore();
            foreach ($resultObj as $answer) {
                $countQuest++;
                if ($answer->answered == "1") $resultScore += $answer->score;
            }
            $result->result = round($resultScore / $maxScore * 100, 2);

            if ($result->result <= 99 && $result->result != 0) $result->result = $result->result + 1; // for student with love <3

            $result->save();

            $this->delete();
        });
    }

    /**
     * @return bool
     */
    public function isTestingComplete()
    {
        $quest_arr = $this->quest_arr;
        $complete = true;
        foreach ($quest_arr as $quest) {
            if ($quest->answered == 0) {
                $complete = false;
                break;
            }
        }
        return $complete;
    }

    /**
     * @return array|bool
     */
    public function startDocker()
    {
        $docker = Docker::create();
        $containers = $docker->containerList();
        $max_containers_count = Settings::getByKey("containers_max_count")->value ?? 1;
        $startHTTPPort=10000;
        $startSSHPort=20000;
        $startFTPPort=30000;

        if (count($containers) < $max_containers_count) {
            $docker_name = $this->quest->docker->name;

            try {
                start_bind:
                $containerConfig = new ContainersCreatePostBody();
                $containerConfig->setImage($docker_name);

                $containerConfig->setTty(true);
                $containerConfig->setExposedPorts(new \ArrayObject([
                    '80/tcp' => new \stdClass,
                    '22/tcp' => new \stdClass,
                    '21/tcp' => new \stdClass,
                ]));

                $portBindingHTTP = new PortBinding();
                $portBindingHTTP->setHostPort($startHTTPPort);
                $portBindingHTTP->setHostIp('0.0.0.0');

                $portBindingSSH = new PortBinding();
                $portBindingSSH->setHostPort($startSSHPort);
                $portBindingSSH->setHostIp('0.0.0.0');

                $portBindingFTP = new PortBinding();
                $portBindingFTP->setHostPort($startFTPPort);
                $portBindingFTP->setHostIp('0.0.0.0');

                $portMap = new \ArrayObject();
                $portMap['80/tcp'] = [$portBindingHTTP];
                $portMap['22/tcp'] = [$portBindingSSH];
                $portMap['21/tcp'] = [$portBindingFTP];

                $hostConfig = new HostConfig();
                $hostConfig->setPortBindings($portMap);

                $containerConfig->setHostConfig($hostConfig);

                $containerCreateResult = $docker->containerCreate($containerConfig);
                $docker->containerStart($containerCreateResult->getId());
                //$docker->containerInspect($containerCreateResult->getId());
                //$contStartResult->getNetworkSettings()->getIPAddress()); // get ip

                $quest_arr = json_decode(json_encode($this->quest_arr), True);
                $quest_arr[$this->id_current_quest]["doc"]["id"] = $containerCreateResult->getId();
                $this->quest_arr = json_encode($quest_arr);
                $this->save();
            }
            catch (Exception $e)
            {
                echo "Error with start docker - ".$e->getMessage();
            }
            catch (\Docker\API\Exception\ContainerStartInternalServerErrorException $e)
            {
                $startHTTPPort++;
                $startSSHPort++;
                $startFTPPort++;
                goto start_bind;
            }

            return [
                "ssh"=>$startSSHPort,
                "ftp"=>$startFTPPort,
                "http"=>$startHTTPPort
            ];
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function stopDocker()
    {
        $docker = Docker::create();
        if (empty($this->quest_arr->{$this->id_current_quest}->doc->id)) return false;
        $cont_id = $this->quest_arr->{$this->id_current_quest}->doc->id;

        try {
            $contStartResult = $docker->containerInspect($cont_id)->getState()->getStatus();
            if ($contStartResult !== "exited")
                $docker->containerStop($cont_id);
        } catch (Exception $e) {
            echo "container not found";
            return false;
        }
        return true;
    }
}
