<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Jul 2019 09:44:47 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * Class MFalureMode
 * 
 * @property int $id
 * @property int $category_id
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\MCategory $m_category
 * @property \Illuminate\Database\Eloquent\Collection $m_falure_mode_translations
 * @property \Illuminate\Database\Eloquent\Collection $m_graduation_categories
 *
 * @package App\Models
 */
class MFalureMode extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_falure_mode';

	protected $casts = [
		'category_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'category_id',
		'status'
	];

	public function m_category()
	{
		return $this->belongsTo(\App\Models\MCategory::class, 'category_id');
	}

	public function m_falure_mode_translations()
	{
		return $this->hasOne(\App\Models\MFalureModeTranslation::class, 'translation_id')->where('language_id', LaravelLocalization::getSupportedLocales()[LaravelLocalization::getCurrentLocale()]['id']);
	}

	public function m_falure_mode_translations_all()
	{
		return $this->hasMany(\App\Models\MFalureModeTranslation::class, 'translation_id');
	}

	public function m_graduation_categories()
	{
		return $this->hasMany(\App\Models\MGraduationCategory::class, 'failure_id');
	}
}
