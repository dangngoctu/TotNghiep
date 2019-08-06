<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 06 Aug 2019 13:47:12 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class SystemManagement
 * 
 * @property int $id
 * @property int $user_id
 * @property int $line_id
 * @property int $area_id
 * @property int $device_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\MArea $m_area
 * @property \App\Models\MDevice $m_device
 * @property \App\Models\MLine $m_line
 * @property \App\Models\MUser $m_user
 *
 * @package App\Models
 */
class SystemManagement extends Eloquent
{
	protected $table = 'system_management';

	protected $casts = [
		'user_id' => 'int',
		'line_id' => 'int',
		'area_id' => 'int',
		'device_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'line_id',
		'area_id',
		'device_id'
	];

	public function m_area()
	{
		return $this->belongsTo(\App\Models\MArea::class, 'area_id');
	}

	public function m_device()
	{
		return $this->belongsTo(\App\Models\MDevice::class, 'device_id');
	}

	public function m_line()
	{
		return $this->belongsTo(\App\Models\MLine::class, 'line_id');
	}

	public function m_user()
	{
		return $this->belongsTo(\App\Models\MUser::class, 'user_id');
	}
}
