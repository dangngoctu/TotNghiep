<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 04 Jul 2019 09:51:54 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MFalureModeDetailTranslation
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
 * @property \App\Models\MFalureModeDetail $m_falure_mode_detail
 *
 * @package App\Models
 */
class MFalureModeDetailTranslation extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_falure_mode_detail_translation';

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

	public function m_falure_mode_detail()
	{
		return $this->belongsTo(\App\Models\MFalureModeDetail::class, 'translation_id');
	}
}
