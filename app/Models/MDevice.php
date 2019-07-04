<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 04 Jul 2019 09:51:54 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use \LiamWiltshire\LaravelJitLoader\Concerns\AutoloadsRelationships;

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
		return $this->hasOne(\App\Models\MDeviceTranslation::class, 'translation_id')->where('language_id', LaravelLocalization::getSupportedLocales()[LaravelLocalization::getCurrentLocale()]['id']);
	}
	
	public function m_device_translations_all()
	{
		return $this->hasMany(\App\Models\MDeviceTranslation::class, 'translation_id');
	}

	public function m_notifications()
	{
		return $this->hasMany(\App\Models\MNotification::class, 'device_id');
	}

	public function system_managements()
	{
		return $this->hasMany(\App\Models\SystemManagement::class, 'device_id');
	}
}
