<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Jul 2019 09:44:47 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * Class MCourse
 * 
 * @property int $id
 * @property int $major_id
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\MMajor $m_major
 * @property \Illuminate\Database\Eloquent\Collection $m_classes
 * @property \Illuminate\Database\Eloquent\Collection $m_course_translations
 *
 * @package App\Models
 */
class MCourse extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_course';

	protected $casts = [
		'major_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'major_id',
		'status'
	];

	public function m_major()
	{
		return $this->belongsTo(\App\Models\MMajor::class, 'major_id');
	}

	public function m_classes()
	{
		return $this->hasMany(\App\Models\MClass::class, 'course_id');
	}

	public function m_course_translations()
	{
		return $this->hasOne(\App\Models\MCourseTranslation::class, 'translation_id')->where('language_id', LaravelLocalization::getSupportedLocales()[LaravelLocalization::getCurrentLocale()]['id']);
	}

	public function m_course_translations_all()
	{
		return $this->hasMany(\App\Models\MCourseTranslation::class, 'translation_id');
	}
}
