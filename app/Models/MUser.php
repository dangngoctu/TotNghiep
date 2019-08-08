<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 02 Jul 2019 16:26:01 +0700.
 */

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Reliese\Database\Eloquent\Model as Eloquent;

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
 * @property \Illuminate\Database\Eloquent\Collection $m_notificaitons
 * @property \Illuminate\Database\Eloquent\Collection $role_users
 * @property \Illuminate\Database\Eloquent\Collection $system_managements
 *
 * @package App\Models
 */
class MUser extends Authenticatable
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
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

	public function m_notificaitons()
	{
		return $this->hasMany(\App\Models\MNotificaiton::class, 'user_id');
	}

	public function role_users()
	{
		return $this->hasMany(\App\Models\RoleUser::class, 'user_id');
	}

	public function system_managements()
	{
		return $this->hasMany(\App\Models\SystemManagement::class, 'user_id');
	}
}
