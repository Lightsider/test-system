<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $id_user
 * @property int $id_test
 * @property string $time
 * @property string $date
 * @property string $result
 * @property string $created_at
 * @property string $updated_at
 * @property Test $test
 * @property User $user
 */
class Results extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['id_user', 'id_test', 'time', 'date', 'result', 'created_at', 'updated_at'];

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
     * @param $value
     * @return false|string
     */

    public function getTimeAttribute($value)
    {
        $time = date('i мин s с', strtotime($value));

        return $time;
    }

    /**
     * @param $value
     * @return false|string
     */

    public function getDateAttribute($value)
    {
        $time = date('d.m.Y', strtotime($value));

        return $time;
    }
}
