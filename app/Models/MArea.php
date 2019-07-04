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
 * Class MArea
 * 
 * @property int $id
 * @property int $site_id
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\MSite $m_site
 * @property \Illuminate\Database\Eloquent\Collection $m_area_translations
 * @property \Illuminate\Database\Eloquent\Collection $m_devices
 * @property \Illuminate\Database\Eloquent\Collection $system_managements
 *
 * @package App\Models
 */
class MArea extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_area';

	protected $casts = [
		'site_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'site_id',
		'status'
	];

	public function m_site()
	{
		return $this->belongsTo(\App\Models\MSite::class, 'site_id');
	}

	public function m_area_translations()
	{
		return $this->hasOne(\App\Models\MAreaTranslation::class, 'translation_id')->where('language_id', LaravelLocalization::getSupportedLocales()[LaravelLocalization::getCurrentLocale()]['id']);
	}
	
	public function m_area_translations_all()
	{
		return $this->hasMany(\App\Models\MAreaTranslation::class, 'translation_id');
	}

	public function m_devices()
	{
		return $this->hasMany(\App\Models\MDevice::class, 'area_id');
	}

	public function system_managements()
	{
		return $this->hasMany(\App\Models\SystemManagement::class, 'area_id');
	}
}
