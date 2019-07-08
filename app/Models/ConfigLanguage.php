<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Jul 2019 09:44:47 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ConfigLanguage
 * 
 * @property int $id
 * @property string $name
 * @property string $code
 * @property bool $default
 * @property string $currency_code
 * @property string $date_format
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $m_categories_translations
 * @property \Illuminate\Database\Eloquent\Collection $m_class_translations
 * @property \Illuminate\Database\Eloquent\Collection $m_course_translations
 * @property \Illuminate\Database\Eloquent\Collection $m_falure_mode_translations
 * @property \Illuminate\Database\Eloquent\Collection $m_major_translations
 *
 * @package App\Models
 */
class ConfigLanguage extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'config_language';

	protected $casts = [
		'default' => 'bool'
	];

	protected $fillable = [
		'name',
		'code',
		'default',
		'currency_code',
		'date_format'
	];

	public function m_categories_translations()
	{
		return $this->hasMany(\App\Models\MCategoriesTranslation::class, 'language_id');
	}

	public function m_class_translations()
	{
		return $this->hasMany(\App\Models\MClassTranslation::class, 'language_id');
	}

	public function m_course_translations()
	{
		return $this->hasMany(\App\Models\MCourseTranslation::class, 'language_id');
	}

	public function m_falure_mode_translations()
	{
		return $this->hasMany(\App\Models\MFalureModeTranslation::class, 'language_id');
	}

	public function m_major_translations()
	{
		return $this->hasMany(\App\Models\MMajorTranslation::class, 'language_id');
	}
}
