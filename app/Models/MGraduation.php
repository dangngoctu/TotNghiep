<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Jul 2019 09:44:47 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MGraduation
 * 
 * @property int $id
 * @property int $user_id
 * @property int $student_id
 * @property string $file
 * @property int $presentation_score
 * @property int $graduation_score
 * @property int $final_score
 * @property string $comment
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\MStudent $m_student
 * @property \App\Models\MUser $m_user
 * @property \Illuminate\Database\Eloquent\Collection $m_graduation_categories
 *
 * @package App\Models
 */
class MGraduation extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_graduation';

	protected $casts = [
		'user_id' => 'int',
		'student_id' => 'int',
		'presentation_score' => 'int',
		'graduation_score' => 'int',
		'final_score' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'user_id',
		'student_id',
		'file',
		'presentation_score',
		'graduation_score',
		'final_score',
		'comment',
		'status'
	];

	public function m_student()
	{
		return $this->belongsTo(\App\Models\MStudent::class, 'student_id');
	}

	public function m_user()
	{
		return $this->belongsTo(\App\Models\MUser::class, 'user_id');
	}

	public function m_graduation_categories()
	{
		return $this->hasMany(\App\Models\MGraduationCategory::class, 'graduation_id');
	}
}
