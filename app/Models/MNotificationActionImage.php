<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 02 Jul 2019 16:26:01 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MNotificationActionImage
 * 
 * @property int $id
 * @property int $notification_action_id
 * @property string $url
 * @property string $hash
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\MNotificationAction $m_notification_action
 *
 * @package App\Models
 */
class MNotificationActionImage extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_notification_action_image';

	protected $casts = [
		'notification_action_id' => 'int'
	];

	protected $fillable = [
		'notification_action_id',
		'url',
		'hash'
	];

	public function m_notification_action()
	{
		return $this->belongsTo(\App\Models\MNotificationAction::class, 'notification_action_id');
	}
}
