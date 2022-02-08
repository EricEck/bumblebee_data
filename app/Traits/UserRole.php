<?php
namespace App\Traits;


use App\Models\Role;
use Illuminate\Support\Facades\DB;

trait UserRole {
//    /**
//     * Get all Teams the user is a member of
//     *
//     * @return Team[]
//     */
//    public function getUserTeams(){
//        $teams = array();
//
//        $allUserRoles = DB::table('role_user')
//            ->where('user_id', $this->id)
//            ->get();
//
//        foreach ($allUserRoles as $userRole){
//            $teams[] = Team::find($userRole->team_id);
//        }
//        return $teams;
//    }

    /**
     * Return a comma seperated string of user's roles
     * @return string
     */
    public function getUserRoleNamesWithCommas(){
        $roleNames = $this->getRoles();
        $roleString = "";
        $count = 0;
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

//    /**
//     * Find the User's Team (first one only)
//     *
//     * @return Team|Team[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
//     */
//    public function getUserTeam(){
//        $userRole = DB::table('role_user')
//            ->where('user_id', $this->id)
//            ->first();
//        return Team::find($userRole->team_id);
//    }
}
