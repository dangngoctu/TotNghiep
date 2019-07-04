<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 04 Jul 2019 09:51:54 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MNotificationImage
 * 
 * @property int $id
 * @property int $notification_id
 * @property string $url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\MNotification $m_notification
 *
 * @package App\Models
 */
class MNotificationImage extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_notification_image';

	protected $casts = [
		'notification_id' => 'int'
	];

	protected $fillable = [
		'notification_id',
		'url'
	];

	public function m_notification()
	{
		return $this->belongsTo(\App\Models\MNotification::class, 'notification_id');
	}
}
