<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 07 Aug 2019 23:14:51 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MFailureModeTranslation
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
 * @property \App\Models\MFailureMode $m_failure_mode
 *
 * @package App\Models
 */
class MFailureModeTranslation extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_failure_mode_translation';

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

	public function m_failure_mode()
	{
		return $this->belongsTo(\App\Models\MFailureMode::class, 'translation_id');
	}
}
