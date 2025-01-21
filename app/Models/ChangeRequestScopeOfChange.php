<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ChangeRequestScopeOfChange
 * 
 * @property int $id
 * @property int $change_request_id
 * @property int $scope_of_change_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property ChangeRequest $change_request
 * @property ScopeOfChange $scope_of_change
 *
 * @package App\Models
 */
class ChangeRequestScopeOfChange extends Model
{
	protected $table = 'change_request_scope_of_changes';

	protected $casts = [
		'change_request_id' => 'int',
		'scope_of_change_id' => 'int'
	];

	protected $fillable = [
		'change_request_id',
		'scope_of_change_id'
	];

	public function change_request()
	{
		return $this->belongsTo(ChangeRequest::class);
	}

	public function scope_of_change()
	{
		return $this->belongsTo(ScopeOfChange::class);
	}
}
