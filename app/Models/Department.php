<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Department
 * 
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|User[] $users
 * @property Collection|ChangeRequest[] $change_requests
 *
 * @package App\Models
 */
class Department extends Model
{
	protected $table = 'departments';

	protected $fillable = [
		'name'
	];

	public function users()
	{
		return $this->hasMany(User::class);
	}

	public function change_requests()
	{
		return $this->belongsToMany(ChangeRequest::class, 'change_request_departments', 'departement_id')
					->withPivot('id')
					->withTimestamps();
	}
}
