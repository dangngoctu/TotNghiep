<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 04 Jul 2019 09:51:54 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MCheckStatus
 * 
 * @property int $id
 * @property int $user_id
 * @property int $notification_id
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\MNotification $m_notification
 * @property \App\Models\MUser $m_user
 *
 * @package App\Models
 */
class MCheckStatus extends Eloquent
{
	protected $table = 'm_check_status';

	protected $casts = [
		'user_id' => 'int',
		'notification_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'user_id',
		'notification_id',
		'status'
	];

	public function m_notification()
	{
		return $this->belongsTo(\App\Models\MNotification::class, 'notification_id');
	}

	public function m_user()
	{
		return $this->belongsTo(\App\Models\MUser::class, 'user_id');
	}
}
