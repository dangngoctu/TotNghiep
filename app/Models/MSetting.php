<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 08 Aug 2019 18:13:44 +0700.
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

	protected $hidden = [];

	protected $fillable = [
		'default_password',
		'limit_upload',
		'phone',
		'logo',
		'GG_KEY_MAP'
	];
}
