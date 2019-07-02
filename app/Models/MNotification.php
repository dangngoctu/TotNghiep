<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 02 Jul 2019 16:26:01 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MNotification
 * 
 * @property int $id
 * @property int $user_id
 * @property int $device_id
 * @property int $priority
 * @property int $evaluation
 * @property int $category_id
 * @property int $falure_id
 * @property int $falure_detail_id
 * @property \Carbon\Carbon $time_action
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \App\Models\MCategory $m_category
 * @property \App\Models\MDevice $m_device
 * @property \App\Models\MFalureModeDetail $m_falure_mode_detail
 * @property \App\Models\MFalureMode $m_falure_mode
 * @property \App\Models\MUser $m_user
 * @property \Illuminate\Database\Eloquent\Collection $m_check_statuses
 * @property \Illuminate\Database\Eloquent\Collection $m_notification_actions
 * @property \Illuminate\Database\Eloquent\Collection $m_notification_images
 * @property \Illuminate\Database\Eloquent\Collection $m_notification_times
 *
 * @package App\Models
 */
class MNotification extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_notification';

	protected $casts = [
		'user_id' => 'int',
		'device_id' => 'int',
		'priority' => 'int',
		'evaluation' => 'int',
		'category_id' => 'int',
		'falure_id' => 'int',
		'falure_detail_id' => 'int'
	];

	protected $dates = [
		'time_action'
	];

	protected $fillable = [
		'user_id',
		'device_id',
		'priority',
		'evaluation',
		'category_id',
		'falure_id',
		'falure_detail_id',
		'time_action'
	];

	public function m_category()
	{
		return $this->belongsTo(\App\Models\MCategory::class, 'category_id');
	}

	public function m_device()
	{
		return $this->belongsTo(\App\Models\MDevice::class, 'device_id');
	}

	public function m_falure_mode_detail()
	{
		return $this->belongsTo(\App\Models\MFalureModeDetail::class, 'falure_detail_id');
	}

	public function m_falure_mode()
	{
		return $this->belongsTo(\App\Models\MFalureMode::class, 'falure_id');
	}

	public function m_user()
	{
		return $this->belongsTo(\App\Models\MUser::class, 'user_id');
	}

	public function m_check_statuses()
	{
		return $this->hasMany(\App\Models\MCheckStatus::class, 'notification_id');
	}

	public function m_notification_actions()
	{
		return $this->hasMany(\App\Models\MNotificationAction::class, 'notification_id');
	}

	public function m_notification_images()
	{
		return $this->hasMany(\App\Models\MNotificationImage::class, 'notification_id');
	}

	public function m_notification_times()
	{
		return $this->hasMany(\App\Models\MNotificationTime::class, 'notification_id');
	}
}
