<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property int $score
 * @property string $type
 * @property string $hint
 */
class Quests extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'questions';

    /**
     * @var array
     */
    protected $fillable = ['title', 'description', 'score','type','hint','created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany('App\Files', 'id_quest');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany('App\Answers', 'id_quest');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function category()
    {
        return $this->belongsToMany('App\Categories', 'quest_to_category',"id_quest","id_category");
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        $type = DB::select( DB::raw("SHOW COLUMNS FROM questions WHERE Field = 'type'") )[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        foreach( explode(',', $matches[1]) as $value )
        {
            $v = trim( $value, "'" );
            switch ($v){
                case "wch":
                    $string = "С развернутым ответом";
                    break;
                case "mch":
                    $string = "С несколькими ответами";
                    break;
                case "doc":
                    $string = "С виртуальным контейнером";
                    break;
                default:
                    $string = "С выбором ответа";

            }
            $enum = array_add($enum, $v, $string);
        }
        return $enum;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function docker()
    {
        return $this->hasOne('App\DockerContainers', 'id_quest');
    }
}
