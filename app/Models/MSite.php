<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 02 Jul 2019 16:26:01 +0700.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MSite
 * 
 * @property int $id
 * @property string $point
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $m_areas
 * @property \Illuminate\Database\Eloquent\Collection $m_site_translations
 *
 * @package App\Models
 */
class MSite extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'm_site';

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'point',
		'status'
	];

	public function m_areas()
	{
		return $this->hasMany(\App\Models\MArea::class, 'site_id');
	}

	public function m_site_translations()
	{
		return $this->hasMany(\App\Models\MSiteTranslation::class, 'translation_id');
	}
}
