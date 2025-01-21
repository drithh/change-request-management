<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ChangeRequestDepartment
 * 
 * @property int $id
 * @property int $change_request_id
 * @property int $departement_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property ChangeRequest $change_request
 * @property Department $department
 *
 * @package App\Models
 */
class ChangeRequestDepartment extends Model
{
	protected $table = 'change_request_departments';

	protected $casts = [
		'change_request_id' => 'int',
		'departement_id' => 'int'
	];

	protected $fillable = [
		'change_request_id',
		'departement_id'
	];

	public function change_request()
	{
		return $this->belongsTo(ChangeRequest::class);
	}

	public function department()
	{
		return $this->belongsTo(Department::class, 'departement_id');
	}
}
