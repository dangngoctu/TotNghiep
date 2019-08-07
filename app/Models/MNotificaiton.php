<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 07 Aug 2019 23:14:51 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MNotificaiton
 * 
 * @property int $id
 * @property int $user_id
 * @property string $file
 * @property int $category_id
 * @property int $failure_id
 * @property string $comment
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\MCategory $m_category
 * @property \App\Models\MFailureMode $m_failure_mode
 * @property \App\Models\MUser $m_user
 *
 * @package App\Models
 */
class MNotificaiton extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_notificaiton';

	protected $casts = [
		'user_id' => 'int',
		'category_id' => 'int',
		'failure_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'user_id',
		'file',
		'category_id',
		'failure_id',
		'comment',
		'status'
	];

	public function m_category()
	{
		return $this->belongsTo(\App\Models\MCategory::class, 'category_id');
	}

	public function m_failure_mode()
	{
		return $this->belongsTo(\App\Models\MFailureMode::class, 'failure_id');
	}

	public function m_user()
	{
		return $this->belongsTo(\App\Models\MUser::class, 'user_id');
	}
}
