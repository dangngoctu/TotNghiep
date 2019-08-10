<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 07 Aug 2019 23:14:51 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MFailureMode
 * 
 * @property int $id
 * @property int $category_id
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\MCategory $m_category
 * @property \Illuminate\Database\Eloquent\Collection $m_failure_mode_translations
 * @property \Illuminate\Database\Eloquent\Collection $m_notificaitons
 *
 * @package App\Models
 */
class MFailureMode extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_failure_mode';

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

	public function m_failure_mode_translations()
	{
		return $this->hasOne(\App\Models\MFailureModeTranslation::class, 'translation_id');
	}

	public function m_notificaitons()
	{
		return $this->hasMany(\App\Models\MNotificaiton::class, 'failure_id');
	}
}
