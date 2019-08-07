<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 07 Aug 2019 23:14:51 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MSetting
 * 
 * @property int $id
 * @property string $default_password
 * @property int $limit_upload
 * @property string $phone
 * @property string $GG_KEY_MAP
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class MSetting extends Eloquent
{
	protected $table = 'm_setting';

	protected $casts = [
		'limit_upload' => 'int'
	];

	protected $hidden = [
		'default_password'
	];

	protected $fillable = [
		'default_password',
		'limit_upload',
		'phone',
		'GG_KEY_MAP'
	];
}
