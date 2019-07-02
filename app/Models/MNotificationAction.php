<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 02 Jul 2019 16:26:01 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MNotificationAction
 * 
 * @property int $id
 * @property int $notification_id
 * @property int $user_id
 * @property string $comment
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\MNotification $m_notification
 * @property \App\Models\MUser $m_user
 * @property \Illuminate\Database\Eloquent\Collection $m_notification_action_images
 *
 * @package App\Models
 */
class MNotificationAction extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_notification_action';

	protected $casts = [
		'notification_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'notification_id',
		'user_id',
		'comment'
	];

	public function m_notification()
	{
		return $this->belongsTo(\App\Models\MNotification::class, 'notification_id');
	}

	public function m_user()
	{
		return $this->belongsTo(\App\Models\MUser::class, 'user_id');
	}

	public function m_notification_action_images()
	{
		return $this->hasMany(\App\Models\MNotificationActionImage::class, 'notification_action_id');
	}
}
