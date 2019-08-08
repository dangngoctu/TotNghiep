<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 08 Aug 2019 18:13:44 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Visit
 * 
 * @property int $id
 * @property string $ip
 * @property int $visitable_id
 * @property string $visitable_type
 * @property \Carbon\Carbon $date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Visit extends Eloquent
{
	protected $casts = [
		'visitable_id' => 'int'
	];

	protected $dates = [
		'date'
	];

	protected $fillable = [
		'ip',
		'visitable_id',
		'visitable_type',
		'date'
	];
}
