<?php

/**
 * Created by ARIS.
 * Date: Wed, 07 Nov 2018 07:11:03 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Laravel\Scout\Searchable;
use Zizaco\Entrust\EntrustPermission;
use \LiamWiltshire\LaravelJitLoader\Concerns\AutoloadsRelationships;
/**
 * Class Permission
 *
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \Illuminate\Database\Eloquent\Collection $roles
 *
 * @package App\Models
 */
class Permission extends EntrustPermission
{
    use AutoloadsRelationships;
    // use Searchable;
    // public $asYouType = true;

    public function toSearchableArray()
    {
        $array = $this->toArray();
        return $array;
    }

    protected $fillable = [
        'name',
        'display_name',
        'description'
    ];

    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class)
            ->withTimestamps();
    }
}
