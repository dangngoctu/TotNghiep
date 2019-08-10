<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 08 Aug 2019 18:13:44 +0700.
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
 * @property \Illuminate\Database\Eloquent\Collection $system_managements
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
		return $this->hasOne(\App\Models\MDeviceTranslation::class, 'translation_id');
	}

	public function system_managements()
	{
		return $this->hasMany(\App\Models\SystemManagement::class, 'device_id');
	}
}
