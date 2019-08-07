<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 07 Aug 2019 23:14:51 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

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
 * @property \Illuminate\Database\Eloquent\Collection $m_failure_modes
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
		return $this->hasMany(\App\Models\MCategoriesTranslation::class, 'translation_id');
	}

	public function m_failure_modes()
	{
		return $this->hasMany(\App\Models\MFailureMode::class, 'category_id');
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
