<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Panel;

/**
 * Class User
 * 
 * @property int $id
 * @property string $name
 * @property string $email
 * @property bool $is_admin
 * @property bool|null $is_verified
 * @property int|null $department_id
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Department|null $department
 * @property Collection|ChangeRequest[] $change_requests
 *
 * @package App\Models
 */
class User extends Authenticatable implements FilamentUser
{
	use  HasFactory, Notifiable;
	protected $table = 'users';

	protected $casts = [
		'is_admin' => 'bool',
		'is_verified' => 'bool',
		'department_id' => 'int'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'is_admin',
		'is_verified',
		'department_id',
		'password',
		'remember_token'
	];

	public function department()
	{
		return $this->belongsTo(Department::class);
	}

	public function change_requests()
	{
		return $this->hasMany(ChangeRequest::class);
	}

	public function canAccessPanel(Panel $panel): bool
	{
		return true;
	}
}
