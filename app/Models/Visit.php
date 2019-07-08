<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 08 Jul 2019 09:44:47 +0700.
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
