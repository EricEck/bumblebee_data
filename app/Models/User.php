<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;
use App\Traits\UserRole;
use PhpParser\Node\Stmt\Return_;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;
    use UserRole;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_mobile',
        'phone_office',
        'phone_home',
        'address_home_id',
        'pool_owner_id',
        'service_employee_id',
        'elliptic_member_id'
    ];

    // defaults
    protected $attributes = [
        'phone_mobile' => '',
        'phone_office' => '',
        'phone_home' => '',
        'address_home_id' => 0,
        'pool_owner_id' => 0,
        'service_employee_id' => 0,
        'elliptic_member_id' => 0,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // eager load
    protected $with = [
        'addressHome',
    ];

    // Eloquent Relationships
    /**
     * All Bumblebees that an user currently owns
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bumblebees(){
        return $this->hasMany(Bumblebee::class, 'owner_id', 'id');
    }
    public function ellipticProducts(){
        return $this->hasMany(EllipticProduct::class, 'pool_owner_id', 'id');
    }
    public function addressHome(){
        return $this->hasOne(Address::class, 'id', 'address_home_id');
    }
    public function poolOwner(){
        return $this->hasOne(PoolOwner::class, 'user_id', 'id');
    }
    public function calibrations(){
        return $this->hasMany(Calibration::class);
    }
    public function ellipticMember(){
        return $this->hasOne(EllipticMember::class, 'id', 'elliptic_member_id');
    }
    public function bodiesOfWater(){
        return $this->hasMany(BodiesOfWater::class, 'pool_owner_id', 'id');
    }

    public function makeEllipticMember(){

    }
    public function removeEllipticMember(){

    }


    // METHODS

    public static function allPoolOwners(){
        return User::whereRoleIs('pool_owner')->get();
    }
    public static function allEllipticMembers(){
        return User::whereRoleIs('elliptic_members')->get();
    }
    public static function allEllipticAdmins(){
        return User::whereRoleIs('elliptic_admins')->get();
    }
    public static function allServiceOwners(){
        return User::whereRoleIs('service_owner')->get();
    }
    public static function allServiceMember(){
        return User::whereRoleIs('service_member')->get();
    }
    /**
     * Minimum Required Validation for a User
     * @return bool
     */
    public function filled():bool {
        return (
            strlen($this->name) >= 4
            && strlen($this->email) > 8
        );
    }

    public function roleNames(){
        return $this->getRoles();
    }

    public function scopeSomeUsers($query){
        return $query->where('id', '>', 2);
    }

    public function scopeAllUsersWithRoleIDs($query){
        return $query->join('role_user','users.id', '=', 'role_user.user_id')
            ->select('users.*', 'role_user.role_id');
    }

    public function scopeAllUsersWithRoleNames($query){
        return $query->allUsersWithRoleIDs()->join('roles','role_id', '=', 'roles.id')
            ->select('users.id', 'users.name', 'users.email', 'roles.display_name as role_name');
    }

    /**
     * Search for specific user(s) across all visible fields
     *
     * @param string $search
     * @return User|\Illuminate\Database\Eloquent\Builder
     */
    public static function searchView(string $search)
    {
        return empty($search) ? static::query()
            : static::query()->where('id', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('name', 'like', '%'.$search.'%');

    }

    /**
     * Return a comma seperated string of user's roles
     * @return string
     */
    public function getUserRoleNamesWithCommas(){
        $roleNames = $this->getRoles();
        $roleString = "";
        $count = 0;
        /** @var array $roleNames */
        foreach ($roleNames as $roleName) {
            $roleDisplay =  Role::where('name', $roleName)->first()->display_name;
            $roleString .= $roleDisplay;
            $count++;
            if($count < count($roleNames)){
                $roleString .= ", ";
            }
        }
        return $roleString;
    }

}
