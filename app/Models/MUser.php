<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 04 Jul 2019 09:51:55 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use \LiamWiltshire\LaravelJitLoader\Concerns\AutoloadsRelationships;

/**
 * Class MUser
 * 
 * @property int $id
 * @property string $phone
 * @property string $password
 * @property string $email
 * @property string $name
 * @property string $avatar
 * @property string $fcm_token
 * @property \Carbon\Carbon $dob
 * @property \Carbon\Carbon $time_update_password
 * @property int $status
 * @property int $is_online
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $m_check_statuses
 * @property \Illuminate\Database\Eloquent\Collection $m_notifications
 * @property \Illuminate\Database\Eloquent\Collection $m_notification_actions
 * @property \Illuminate\Database\Eloquent\Collection $m_notification_times
 * @property \Illuminate\Database\Eloquent\Collection $role_users
 * @property \Illuminate\Database\Eloquent\Collection $system_managements
 *
 * @package App\Models
 */
class MUser extends Authenticatable
{
	use Notifiable, AutoloadsRelationships;
    use SoftDeletes, EntrustUserTrait {
        SoftDeletes::restore insteadof EntrustUserTrait;
        EntrustUserTrait::restore insteadof SoftDeletes;
	}
	protected $table = 'm_user';

	protected $casts = [
		'status' => 'int',
		'is_online' => 'int'
	];

	protected $dates = [
		'dob',
		'time_update_password'
	];

	protected $hidden = [
		'password',
		'fcm_token',
		'time_update_password',
		'remember_token'
	];

	protected $fillable = [
		'phone',
		'password',
		'email',
		'name',
		'avatar',
		'fcm_token',
		'dob',
		'time_update_password',
		'status',
		'is_online',
		'remember_token'
	];

	public function role_users()
	{
		return $this->hasMany(\App\Models\RoleUser::class, 'user_id');
	}

	public function m_graduations()
	{
		return $this->hasMany(\App\Models\MGraduation::class, 'user_id');
	}
}
