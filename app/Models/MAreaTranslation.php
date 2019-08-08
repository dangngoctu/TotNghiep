<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 08 Aug 2019 18:13:44 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MAreaTranslation
 * 
 * @property int $id
 * @property string $name
 * @property int $translation_id
 * @property int $language_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\ConfigLanguage $config_language
 * @property \App\Models\MArea $m_area
 *
 * @package App\Models
 */
class MAreaTranslation extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_area_translation';

	protected $casts = [
		'translation_id' => 'int',
		'language_id' => 'int'
	];

	protected $fillable = [
		'name',
		'translation_id',
		'language_id'
	];

	public function config_language()
	{
		return $this->belongsTo(\App\Models\ConfigLanguage::class, 'language_id');
	}

	public function m_area()
	{
		return $this->belongsTo(\App\Models\MArea::class, 'translation_id');
	}
}
