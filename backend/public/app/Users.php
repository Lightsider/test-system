<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

/**
 * @property int $id
 * @property int $id_status
 * @property string $login
 * @property string $password
 * @property string $fullname
 * @property string $group
 * @property string $created_at
 * @property string $updated_at
 * @property UsersStatus $usersStatus
 */
class Users extends BaseModel implements AuthenticatableContract
{
    use Authenticatable;
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $fillable = ['id_status', 'login', 'password', 'fullname', 'group', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usersStatus()
    {
        return $this->belongsTo('App\UsersStatus', 'id_status');
    }
}
