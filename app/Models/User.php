<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
    public static function search(string $search)
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
