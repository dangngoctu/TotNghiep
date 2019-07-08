<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Jul 2019 09:44:47 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * Class MMajor
 * 
 * @property int $id
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $m_courses
 * @property \Illuminate\Database\Eloquent\Collection $m_major_translations
 *
 * @package App\Models
 */
class MMajor extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_major';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'status'
	];

	public function m_courses()
	{
		return $this->hasMany(\App\Models\MCourse::class, 'major_id');
	}

	public function m_major_translations_all()
	{
		return $this->hasMany(\App\Models\MMajorTranslation::class, 'translation_id');
	}

	public function m_major_translations()
	{
		return $this->hasOne(\App\Models\MMajorTranslation::class, 'translation_id')->where('language_id', LaravelLocalization::getSupportedLocales()[LaravelLocalization::getCurrentLocale()]['id']);;
	}
}
