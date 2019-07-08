<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Jul 2019 09:44:47 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MStudent
 * 
 * @property int $id
 * @property int $mssv
 * @property string $name
 * @property string $phone
 * @property string $avatar
 * @property string $address
 * @property int $class_id
 * @property \Carbon\Carbon $dob
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\MClass $m_class
 * @property \Illuminate\Database\Eloquent\Collection $m_graduations
 *
 * @package App\Models
 */
class MStudent extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_student';

	protected $casts = [
		'mssv' => 'int',
		'class_id' => 'int',
		'status' => 'int'
	];

	protected $dates = [
		'dob'
	];

	protected $fillable = [
		'mssv',
		'name',
		'phone',
		'avatar',
		'address',
		'class_id',
		'dob',
		'status'
	];

	public function m_class()
	{
		return $this->belongsTo(\App\Models\MClass::class, 'class_id');
	}

	public function m_graduations()
	{
		return $this->hasMany(\App\Models\MGraduation::class, 'student_id');
	}
}
