<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 08 Aug 2019 18:13:44 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * Class MArea
 * 
 * @property int $id
 * @property int $line_id
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\MLine $m_line
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
		'line_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'line_id',
		'status'
	];

	public function m_line()
	{
		return $this->belongsTo(\App\Models\MLine::class, 'line_id');
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
