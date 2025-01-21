<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ScopeOfChange
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
class ScopeOfChange extends Model
{
	protected $table = 'scope_of_changes';

	protected $fillable = [
		'value'
	];

	public function change_requests()
	{
		return $this->belongsToMany(ChangeRequest::class, 'change_request_scope_of_changes')
					->withPivot('id')
					->withTimestamps();
	}
}
