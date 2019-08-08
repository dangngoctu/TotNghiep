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
 * Class PermissionRole
 *
 * @property int $permission_id
 * @property int $role_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \App\Models\Permission $permission
 * @property \App\Models\Role $role
 *
 * @package App\Models
 */
class PermissionRole extends Eloquent
{
    use AutoloadsRelationships;
    // use Searchable;
    // public $asYouType = true;

    public function toSearchableArray()
    {
        $array = $this->toArray();
        return $array;
    }

    protected $table = 'permission_role';
    public $incrementing = false;

    protected $casts = [
        'permission_id' => 'int',
        'role_id' => 'int'
    ];

    public function permission()
    {
        return $this->belongsTo(\App\Models\Permission::class);
    }

    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class);
    }
}
