<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Jul 2019 09:44:47 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * Class MClass
 * 
 * @property int $id
 * @property int $course_id
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\MCourse $m_course
 * @property \Illuminate\Database\Eloquent\Collection $m_class_translations
 * @property \Illuminate\Database\Eloquent\Collection $m_students
 *
 * @package App\Models
 */
class MClass extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_class';

	protected $casts = [
		'course_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'course_id',
		'status'
	];

	public function m_course()
	{
		return $this->belongsTo(\App\Models\MCourse::class, 'course_id');
	}

	public function m_class_translations()
	{
		return $this->hasOne(\App\Models\MClassTranslation::class, 'translation_id')->where('language_id', LaravelLocalization::getSupportedLocales()[LaravelLocalization::getCurrentLocale()]['id']);
	}

	public function m_class_translations_all()
	{
		return $this->hasMany(\App\Models\MClassTranslation::class, 'translation_id');
	}

	public function m_students()
	{
		return $this->hasMany(\App\Models\MStudent::class, 'class_id');
	}
}
