<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Used to perform Team functions
 */
class TeamController extends Controller
{
    /**
     * Get all Teams the user is a member of
     *
     * @param User $user
     * @return Team[]
     */
    public function getUsersTeams(User $user){
        $teams = array();

        $allUserRoles = DB::table('role_user')
            ->where('user_id', $user->id)
            ->get();

       foreach ($allUserRoles as $userRole){
            $teams[] = Team::find($userRole->team_id);
        }
        return $teams;
    }
}
