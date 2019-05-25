<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function getTimeAttribute($value)
    {
        $time = date('H:i', strtotime($value));

        return $time;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function category()
    {
        return $this->belongsToMany('App\Categories', 'test_to_category',"id_test","id_category");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions()
    {
        return $this->belongsToMany('App\Quests', 'test_to_quest',"id_test","id_quest");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function results()
    {
        return $this->hasMany('App\Results',"id_test");
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        $type = DB::select( DB::raw("SHOW COLUMNS FROM tests WHERE Field = 'type'") )[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        foreach( explode(',', $matches[1]) as $value )
        {
            $v = trim( $value, "'" );
            switch ($v){
                case "learn":
                    $string = "Обучающий";
                    break;
                default:
                    $string = "Контрольный";

            }
            $enum = array_add($enum, $v, $string);
        }
        return $enum;
    }

//    public function getGoing()
//    {
//        return TempTesting::where()
//    }

}
