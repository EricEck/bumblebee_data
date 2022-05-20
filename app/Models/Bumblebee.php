<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
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
        'removed_from_service',
        'api_password',
        'remember_token'
    ];

    protected $hidden = [
        'api_password'
    ];

    // eager load
    protected $with = [];

    // Eloquent Relationships
    public function measurements(){
        return $this->hasMany(Measurement::class);
    }
    public function calibrations(){
        return $this->hasMany(Calibration::class);
    }
    public function ellipticProduct(){
        return $this->belongsTo(EllipticProduct::class, 'id', 'bumblebee_id');
    }
    public function owner(){
        return $this->hasOne(User::class, 'id', 'owner_id');
    }


    // METHODS

    /**
     * Is this assigned to Elliptic Product
     * @return bool
     */
    public function isEllipticProduct(): bool {
        if ($this->ellipticProduct === null){
            return false;
        }
        return true;
    }

    public function bodyOfWater(){
        if($this->ellipticProduct)
            if($this->ellipticProduct->bowComponent)
                return $this->ellipticProduct->bowComponent->bodyOfWater;
        return null;
    }


//    public function owner(){
//        if ($this->ellipticProduct)
//            return $this->ellipticProduct->owner();
//        return User::find($this->owner_id);
//    }

    public function filled(){
        return (
            strlen($this->serial_number) > 3
            && strlen($this->current_version) > 3
        );
    }

    /**
     * Search for specific bumblebee(s) across all visible fields
     *
     * @param string $search
     * @return Bumblebee|\Illuminate\Database\Eloquent\Builder
     */
    public static function searchView(string $search){

        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
            ->orWhere('serial_number', 'like', '%'.$search.'%');
    }

}
