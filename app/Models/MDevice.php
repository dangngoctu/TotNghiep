<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 02 Jul 2019 16:26:01 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MDevice
 * 
 * @property int $id
 * @property int $area_id
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\MArea $m_area
 * @property \Illuminate\Database\Eloquent\Collection $m_device_translations
 * @property \Illuminate\Database\Eloquent\Collection $m_notifications
 *
 * @package App\Models
 */
class MDevice extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_device';

	protected $casts = [
		'area_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'area_id',
		'status'
	];

	public function m_area()
	{
		return $this->belongsTo(\App\Models\MArea::class, 'area_id');
	}

	public function m_device_translations()
	{
		return $this->hasMany(\App\Models\MDeviceTranslation::class, 'translation_id');
	}

	public function m_notifications()
	{
		return $this->hasMany(\App\Models\MNotification::class, 'device_id');
	}
}
