<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Jul 2019 09:44:47 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MGraduationCategory
 * 
 * @property int $id
 * @property int $graduation_id
 * @property int $category_id
 * @property int $failure_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\MCategory $m_category
 * @property \App\Models\MFalureMode $m_falure_mode
 * @property \App\Models\MGraduation $m_graduation
 *
 * @package App\Models
 */
class MGraduationCategory extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_graduation_category';

	protected $casts = [
		'graduation_id' => 'int',
		'category_id' => 'int',
		'failure_id' => 'int'
	];

	protected $fillable = [
		'graduation_id',
		'category_id',
		'failure_id'
	];

	public function m_category()
	{
		return $this->belongsTo(\App\Models\MCategory::class, 'category_id');
	}

	public function m_falure_mode()
	{
		return $this->belongsTo(\App\Models\MFalureMode::class, 'failure_id');
	}

	public function m_graduation()
	{
		return $this->belongsTo(\App\Models\MGraduation::class, 'graduation_id');
	}
}
