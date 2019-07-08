<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Jul 2019 09:44:47 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MCategoriesTranslation
 * 
 * @property int $id
 * @property string $description
 * @property string $name
 * @property int $translation_id
 * @property int $language_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\ConfigLanguage $config_language
 * @property \App\Models\MCategory $m_category
 *
 * @package App\Models
 */
class MCategoriesTranslation extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_categories_translation';

	protected $casts = [
		'translation_id' => 'int',
		'language_id' => 'int'
	];

	protected $fillable = [
		'description',
		'name',
		'translation_id',
		'language_id'
	];

	public function config_language()
	{
		return $this->belongsTo(\App\Models\ConfigLanguage::class, 'language_id');
	}

	public function m_category()
	{
		return $this->belongsTo(\App\Models\MCategory::class, 'translation_id');
	}
}
