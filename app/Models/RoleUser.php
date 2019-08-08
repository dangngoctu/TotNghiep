<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 02 Jul 2019 16:26:01 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class RoleUser
 * 
 * @property int $user_id
 * @property int $role_id
 * 
 * @property \App\Models\Role $role
 * @property \App\Models\MUser $m_user
 *
 * @package App\Models
 */
class RoleUser extends Eloquent
{
	protected $table = 'role_user';
	public $incrementing = false;
	public $timestamps = false;

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
