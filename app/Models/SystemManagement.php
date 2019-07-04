<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 04 Jul 2019 09:51:55 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class SystemManagement
 * 
 * @property int $id
 * @property int $user_id
 * @property int $site_id
 * @property int $device_id
 * @property int $area_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\MArea $m_area
 * @property \App\Models\MDevice $m_device
 * @property \App\Models\MSite $m_site
 * @property \App\Models\MUser $m_user
 *
 * @package App\Models
 */
class SystemManagement extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'system_management';

	protected $casts = [
		'user_id' => 'int',
		'site_id' => 'int',
		'device_id' => 'int',
		'area_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'site_id',
		'device_id',
		'area_id'
	];

	public function m_area()
	{
		return $this->belongsTo(\App\Models\MArea::class, 'area_id');
	}

	public function m_device()
	{
		return $this->belongsTo(\App\Models\MDevice::class, 'device_id');
	}

	public function m_site()
	{
		return $this->belongsTo(\App\Models\MSite::class, 'site_id');
	}

	public function m_user()
	{
		return $this->belongsTo(\App\Models\MUser::class, 'user_id');
	}
}
