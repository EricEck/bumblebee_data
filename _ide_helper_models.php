<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Bumblebee
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $serial_number
 * @property string|null $manufactured_date
 * @property string|null $current_version
 * @property int|null $manufacturer_id
 * @property int|null $owner_id
 * @property int|null $install_id
 * @property string|null $assigned_to_owner_on
 * @property int $removed_from_service
 * @property string|null $api_password
 * @property string $remember_token
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\BumblebeeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereApiPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereAssignedToOwnerOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereCurrentVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereInstallId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereManufacturedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereManufacturerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereRemovedFromService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bumblebee whereSerialNumber($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Calibration[] $calibrations
 * @property-read int|null $calibrations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Measurement[] $measurements
 * @property-read int|null $measurements_count
 * @property-read \App\Models\User|null $owner
 */
	class Bumblebee extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Calibration
 *
 * @property int $id
 * @property int $bumblebee_id
 * @property int $calibrator_id
 * @property string $calibration_type
 * @property string $metric
 * @property string $method
 * @property string $default_input_units
 * @property string $default_output_units
 * @property float $slope_m
 * @property float $offset_b
 * @property boolean $effective
 * @property \Illuminate\Support\Carbon $effective_timestamp
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Bumblebee|null $bumblebee
 * @property-read \App\Models\User|null $calibrator
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration query()
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereBumblebeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereCalibrationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereCalibratorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereDefaultInputUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereDefaultOutputUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereEffective($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereEffectiveTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereMetric($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereOffsetB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereSlopeM($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calibration whereUpdatedAt($value)
 */
	class Calibration extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Measurement
 *
 * @property int $id
 * @property int $bumblebee_id
 * @property \Illuminate\Support\Carbon|null $measurement_timestamp
 * @property int $metric_sequence
 * @property string $metric
 * @property string $method
 * @property string|null $value
 * @property string|null $unit
 * @property string|null $details
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereBumblebeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereMeasurementTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereMetric($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereMetricSequence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereValue($value)
 * @mixin \Eloquent
 * @property string|null $process
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereProcess($value)
 * @method static \Database\Factories\MeasurementFactory factory(...$parameters)
 * @property int $calibration_value
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereCalibrationValue($value)
 * @property float $calibrated_value
 * @property string $calibrated_unit
 * @property int $calibration_id
 * @property-read \App\Models\Bumblebee|null $bumblebee
 * @property-read \App\Models\Calibration|null $calibration
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereCalibratedUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereCalibratedValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Measurement whereCalibrationId($value)
 */
	class Measurement extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bumblebee[] $bumblebees
 * @property-read int|null $bumblebees_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Calibration[] $calibrations
 * @property-read int|null $calibrations_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User allUsersWithRoleIDs()
 * @method static \Illuminate\Database\Eloquent\Builder|User allUsersWithRoleNames()
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User orWherePermissionIs($permission = '')
 * @method static \Illuminate\Database\Eloquent\Builder|User orWhereRoleIs($role = '', $team = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User someUsers()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDoesntHavePermission()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDoesntHaveRole()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePermissionIs($permission = '', $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRoleIs($role = '', $team = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

