<?php
namespace App\Traits;

use App\Models\Team;
use Illuminate\Support\Facades\DB;

trait UserTeam {
    /**
     * Get all Teams the user is a member of
     *
     * @return Team[]
     */
    public function getUserTeams(){
        $teams = array();

        $allUserRoles = DB::table('role_user')
            ->where('user_id', $this->id)
            ->get();

        foreach ($allUserRoles as $userRole){
            $teams[] = Team::find($userRole->team_id);
        }
        return $teams;
    }

    /**
     * Find the User's Team (first one only)
     *
     * @return Team|Team[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getUserTeam(){
        $userRole = DB::table('role_user')
            ->where('user_id', $this->id)
            ->first();
        return Team::find($userRole->team_id);
    }
}
