<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ChangeRequestStimuliOfChange
 * 
 * @property int $id
 * @property int $change_request_id
 * @property int $stimuli_of_change_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property ChangeRequest $change_request
 * @property StimuliOfChange $stimuli_of_change
 *
 * @package App\Models
 */
class ChangeRequestStimuliOfChange extends Model
{
	protected $table = 'change_request_stimuli_of_changes';

	protected $casts = [
		'change_request_id' => 'int',
		'stimuli_of_change_id' => 'int'
	];

	protected $fillable = [
		'change_request_id',
		'stimuli_of_change_id'
	];

	public function change_request()
	{
		return $this->belongsTo(ChangeRequest::class);
	}

	public function stimuli_of_change()
	{
		return $this->belongsTo(StimuliOfChange::class);
	}
}
