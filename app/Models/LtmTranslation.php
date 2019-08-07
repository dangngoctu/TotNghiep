<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 07 Aug 2019 23:14:51 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LtmTranslation
 * 
 * @property int $id
 * @property int $status
 * @property string $locale
 * @property string $group
 * @property string $key
 * @property string $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class LtmTranslation extends Eloquent
{
	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'status',
		'locale',
		'group',
		'key',
		'value'
	];
}
