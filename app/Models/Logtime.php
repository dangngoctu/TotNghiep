<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 16 Sep 2019 13:27:41 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Logtime
 * 
 * @property int $id
 * @property int $user_id
 * @property \Carbon\Carbon $time_in
 * @property \Carbon\Carbon $time_out
 * @property string $hash
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\MUser $m_user
 *
 * @package App\Models
 */
class Logtime extends Eloquent
{
	protected $table = 'logtime';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $dates = [
		'time_in',
		'time_out'
	];

	protected $fillable = [
		'user_id',
		'time_in',
		'time_out',
		'hash'
	];

	public function m_user()
	{
		return $this->belongsTo(\App\Models\MUser::class, 'user_id');
	}
}
