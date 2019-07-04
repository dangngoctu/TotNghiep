<?php

/**
 * Created by ARIS.
 * Date: Wed, 07 Nov 2018 07:11:03 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Laravel\Scout\Searchable;
use \LiamWiltshire\LaravelJitLoader\Concerns\AutoloadsRelationships;
/**
 * Class RoleUser
 *
 * @property int $user_id
 * @property int $role_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \App\Models\Role $role
 * @property \App\Models\MUser $m_user
 *
 * @package App\Models
 */
class RoleUser extends Eloquent
{
    use AutoloadsRelationships;
    // use Searchable;
    // public $asYouType = true;

    public function toSearchableArray()
    {
        $array = $this->toArray();
        return $array;
    }

    protected $table = 'role_user';
    public $incrementing = false;

    protected $casts = [
        'user_id' => 'int',
        'role_id' => 'int'
    ];

    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class);
    }

    public function m_user()
    {
        return $this->belongsTo(\App\Models\MUser::class, 'user_id');
    }
}
