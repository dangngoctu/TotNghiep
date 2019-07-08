<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Jul 2019 09:44:47 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * Class MCategory
 * 
 * @property int $id
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $m_categories_translations
 * @property \Illuminate\Database\Eloquent\Collection $m_falure_modes
 * @property \Illuminate\Database\Eloquent\Collection $m_graduation_categories
 *
 * @package App\Models
 */
class MCategory extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'status'
	];

	public function m_categories_translations()
	{
		return $this->hasOne(\App\Models\MCategoriesTranslation::class, 'translation_id')->where('language_id', LaravelLocalization::getSupportedLocales()[LaravelLocalization::getCurrentLocale()]['id']);
	}

	public function m_categories_translations_all()
	{
		return $this->hasMany(\App\Models\MCategoriesTranslation::class, 'translation_id');
	}

	public function m_falure_modes()
	{
		return $this->hasMany(\App\Models\MFalureMode::class, 'category_id');
	}

	public function m_graduation_categories()
	{
		return $this->hasMany(\App\Models\MGraduationCategory::class, 'category_id');
	}
}
