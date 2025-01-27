<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ChangeRequest
 * 
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $title
 * @property int $user_id
 * @property int $department_id
 * @property string $status
 * @property string $status_url
 * @property string $change_request
 * @property string $change_request_url
 * @property string $reason
 * @property string $support_document_url
 * @property string $source_of_risk
 * @property string $impact_of_risk
 * @property string $risk_evaluation_criteria_severity
 * @property string $causes_of_risk
 * @property string $risk_evaluation_criteria_probability
 * @property string $control_that_has_been_implemented
 * @property string $risk_evaluation_criteria_detectability
 * @property int $risk_priority_number
 * @property string $risk_category
 * @property int $facility_change_authorization_id
 * @property int $regulatory_assesment_id
 * @property int $halal_assesment_id
 * @property string|null $third_party_name
 * 
 * @property User $user
 * @property Department $department
 * @property FacilityChangeAuthorization $facility_change_authorization
 * @property RegulatoryAssesment $regulatory_assesment
 * @property HalalAssesment $halal_assesment
 * @property Collection|ScopeOfChange[] $scope_of_changes
 * @property Collection|StimuliOfChange[] $stimuli_of_changes
 * @property Collection|Department[] $departments
 *
 * @package App\Models
 */
class ChangeRequest extends Model
{
	protected $table = 'change_requests';

	protected $casts = [
		'user_id' => 'int',
		'department_id' => 'int',
		'risk_priority_number' => 'int',
		'facility_change_authorization_id' => 'int',
		'regulatory_assesment_id' => 'int',
		'halal_assesment_id' => 'int'
	];

	protected $fillable = [
		'title',
		'user_id',
		'department_id',
		'status',
		'status_url',
		'change_request',
		'change_request_url',
		'reason',
		'support_document_url',
		'source_of_risk',
		'impact_of_risk',
		'risk_evaluation_criteria_severity',
		'causes_of_risk',
		'risk_evaluation_criteria_probability',
		'control_that_has_been_implemented',
		'risk_evaluation_criteria_detectability',
		'risk_priority_number',
		'risk_category',
		'facility_change_authorization_id',
		'regulatory_assesment_id',
		'halal_assesment_id',
		'third_party_name'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function department()
	{
		return $this->belongsTo(Department::class);
	}

	public function facility_change_authorization()
	{
		return $this->belongsTo(FacilityChangeAuthorization::class);
	}

	public function regulatory_assesment()
	{
		return $this->belongsTo(RegulatoryAssesment::class);
	}

	public function halal_assesment()
	{
		return $this->belongsTo(HalalAssesment::class);
	}

	public function scope_of_changes()
	{
		return $this->belongsToMany(ScopeOfChange::class, 'change_request_scope_of_changes')
			->withPivot('id')
			->withTimestamps();
	}

	public function stimuli_of_changes()
	{
		return $this->belongsToMany(StimuliOfChange::class, 'change_request_stimuli_of_changes')
			->withPivot('id')
			->withTimestamps();
	}

	public function departments()
	{
		return $this->belongsToMany(Department::class, 'change_request_departments', 'change_request_id', 'departement_id')
			->withPivot('id')
			->withTimestamps();
	}
}
