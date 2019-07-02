<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 02 Jul 2019 16:26:01 +0700.
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
 * @property \Illuminate\Database\Eloquent\Collection $m_falure_modes
 * @property \Illuminate\Database\Eloquent\Collection $m_notifications
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

	public function m_falure_modes()
	{
		return $this->hasMany(\App\Models\MFalureMode::class, 'category_id');
	}

	public function m_notifications()
	{
		return $this->hasMany(\App\Models\MNotification::class, 'category_id');
	}
}
