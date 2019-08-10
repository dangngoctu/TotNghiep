<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 08 Aug 2019 18:13:44 +0700.
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
 * @property \Illuminate\Database\Eloquent\Collection $m_notificaitons
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

	public function m_notificaitons()
	{
		return $this->hasMany(\App\Models\MNotificaiton::class, 'category_id');
	}
}
