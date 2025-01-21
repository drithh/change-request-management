<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RegulatoryAssesment
 * 
 * @property int $id
 * @property string $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|ChangeRequest[] $change_requests
 *
 * @package App\Models
 */
class RegulatoryAssesment extends Model
{
	protected $table = 'regulatory_assesments';

	protected $fillable = [
		'value'
	];

	public function change_requests()
	{
		return $this->hasMany(ChangeRequest::class);
	}
}
