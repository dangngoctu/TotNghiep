<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 04 Jul 2019 09:51:55 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use \LiamWiltshire\LaravelJitLoader\Concerns\AutoloadsRelationships;

/**
 * Class MSite
 * 
 * @property int $id
 * @property string $point
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $m_areas
 * @property \Illuminate\Database\Eloquent\Collection $m_site_translations
 * @property \Illuminate\Database\Eloquent\Collection $system_managements
 *
 * @package App\Models
 */
class MSite extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_site';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'point',
		'status'
	];

	public function m_areas()
	{
		return $this->hasMany(\App\Models\MArea::class, 'site_id');
	}
	
	public function m_site_translations()
	{
		return $this->hasOne(\App\Models\MSiteTranslation::class, 'translation_id')->where('language_id', LaravelLocalization::getSupportedLocales()[LaravelLocalization::getCurrentLocale()]['id']);
	}
	
	public function m_site_translations_all()
	{
		return $this->hasMany(\App\Models\MSiteTranslation::class, 'translation_id');
	}

	public function system_managements()
	{
		return $this->hasMany(\App\Models\SystemManagement::class, 'site_id');
	}
}
