<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 04 Jul 2019 09:51:54 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MNotificationTime
 * 
 * @property int $id
 * @property int $user_id
 * @property int $notification_id
 * @property int $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\MNotification $m_notification
 * @property \App\Models\MUser $m_user
 *
 * @package App\Models
 */
class MNotificationTime extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_notification_time';

	protected $casts = [
		'user_id' => 'int',
		'notification_id' => 'int',
		'type' => 'int'
	];

	protected $fillable = [
		'user_id',
		'notification_id',
		'type'
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
