<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 08 Aug 2019 18:13:44 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MLine
 * 
 * @property int $id
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $m_areas
 * @property \Illuminate\Database\Eloquent\Collection $m_line_translations
 * @property \Illuminate\Database\Eloquent\Collection $system_managements
 *
 * @package App\Models
 */
class MLine extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_line';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'status'
	];

	public function m_areas()
	{
		return $this->hasMany(\App\Models\MArea::class, 'line_id');
	}

	public function m_line_translations()
	{
		return $this->hasOne(\App\Models\MLineTranslation::class, 'translation_id');
	}

	public function system_managements()
	{
		return $this->hasMany(\App\Models\SystemManagement::class, 'line_id');
	}
}
