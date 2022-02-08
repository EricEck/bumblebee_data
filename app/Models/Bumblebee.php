<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


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
 */
//old: class Bumblebee extends Model
class Bumblebee extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'serial_number',
        'manufactured_date',
        'current_version',
        'manufacturer_id',
        'owner_id',
        'install_id',
        'assigned_to_owner_on',
        'api_password',
        'remember_token'
    ];

    protected $hidden = [
        'api_password'
    ];
}
