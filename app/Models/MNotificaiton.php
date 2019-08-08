<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 08 Aug 2019 18:13:44 +0700.
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
 * @property \App\Models\MFalureMode $m_falure_mode
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

	public function m_falure_mode()
	{
		return $this->belongsTo(\App\Models\MFalureMode::class, 'failure_id');
	}

	public function m_user()
	{
		return $this->belongsTo(\App\Models\MUser::class, 'user_id');
	}
}
