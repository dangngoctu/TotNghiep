<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 02 Jul 2019 16:26:01 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MFalureModeDetail
 * 
 * @property int $id
 * @property int $falure_id
 * @property int $weight_factor
 * @property int $is_HOC
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\MFalureMode $m_falure_mode
 * @property \Illuminate\Database\Eloquent\Collection $m_falure_mode_detail_translations
 * @property \Illuminate\Database\Eloquent\Collection $m_notifications
 *
 * @package App\Models
 */
class MFalureModeDetail extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_falure_mode_detail';

	protected $casts = [
		'falure_id' => 'int',
		'weight_factor' => 'int',
		'is_HOC' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'falure_id',
		'weight_factor',
		'is_HOC',
		'status'
	];

	public function m_falure_mode()
	{
		return $this->belongsTo(\App\Models\MFalureMode::class, 'falure_id');
	}

	public function m_falure_mode_detail_translations()
	{
		return $this->hasMany(\App\Models\MFalureModeDetailTranslation::class, 'translation_id');
	}

	public function m_notifications()
	{
		return $this->hasMany(\App\Models\MNotification::class, 'falure_detail_id');
	}
}
