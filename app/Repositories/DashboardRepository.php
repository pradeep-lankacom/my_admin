<?php

namespace App\Repositories;

use App\Models\Activity;
use App\Models\Mission;
use App\Repositories\Contracts\DashboardInterface;
use Datatables;
use Auth;
use MongoDB\Driver\Query;

class DashboardRepository implements DashboardInterface
{
    protected $activity;
    protected $mission;

    public function __construct(
    Activity $activity,
    Mission $mission
  ) {
        $this->activity = $activity;
        $this->mission = $mission;
    }



    /**Get pending approvals for the World Bank users  */
    public function get_pending_wb_approvals(){
        try {

            $role_name = Auth::user()->roles->first()->name;
            $User_id = Auth::user()->id;

            $pending_approvals = \DB::table('activity_mission')
                ->join('missions', 'activity_mission.mission_id', '=', 'missions.id')
                ->join('activities', 'activity_mission.activity_id', '=', 'activities.id');

            if ($role_name==config('role.acs')){

                $pending_approvals=$pending_approvals ->where('activities.name', 'LIKE', "Waiting Approval PL")
                                                      ->where('activity_mission.created_by', '=', $User_id);

            }elseif($role_name!=config('role.super_admin') && $role_name!=config('role.wb_admin') && $role_name!=config('role.ttl')){

                    $pending_approvals=$pending_approvals ->where('activities.name', 'LIKE', "Mission Approval $role_name")
                                                          ->where('activity_mission.created_by', '=', $User_id);

            }
                $pending_approvals=$pending_approvals ->whereIn('missions.activity_id', [4,5,6,8,9,10,12,13,14])
                                                      ->where('missions.is_draft', '=', '0')
                ->distinct('activity_mission.mission_id')
                ->count('missions.id');
              //  ->tosql();




            if(!empty($pending_approvals)){
                return $pending_approvals;
            }else{
                return 0;
            }

        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }

    }


    /**Get Pending approvals from ERD for the World Bank users  */
    public function get_pending_erd_approvals(){
        try {

            $role_name = Auth::user()->roles->first()->name;
            $User_id = Auth::user()->id;

            $pending_erd_approvals = \DB::table('activity_mission')
                ->join('missions', 'activity_mission.mission_id', '=', 'missions.id')
                ->join('activities', 'activity_mission.activity_id', '=', 'activities.id');

            if ($role_name==config('role.acs')){

                $pending_erd_approvals=$pending_erd_approvals ->where('activities.name', 'LIKE', "Waiting Approval PL")
                    ->where('activity_mission.created_by', '=', $User_id);

            }elseif($role_name!=config('role.super_admin') && $role_name!=config('role.wb_admin')  && $role_name!=config('role.ttl')){

                $pending_erd_approvals=$pending_erd_approvals ->where('activities.name', 'LIKE', "Mission Approval $role_name")
                    ->where('activity_mission.created_by', '=', $User_id);

            }

            $pending_erd_approvals=$pending_erd_approvals ->whereIn('missions.activity_id', [16,17,19,20,21])
                ->where('missions.is_draft', '=', '0')
                ->distinct('activity_mission.mission_id')
                ->count('missions.id');


            if(!empty($pending_erd_approvals)){
                return $pending_erd_approvals;
            }else{
                return 0;
            }

        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }

    }



    /**Get Total approved from  World Bank users Today  */
    public function get_total_approved_mission(){
        try {

            $role_name = Auth::user()->roles->first()->name;
            $User_id = Auth::user()->id;
            $today=date("Y-m-d 00:00:00");
            $tomorrow = date("Y-m-d 00:00:00", strtotime("+1 day"));

                $pending_total_approvals = \DB::table('activity_mission')
                                      ->join('activities', 'activity_mission.activity_id', '=', 'activities.id')
                                      ->select('activity_mission.mission_id');
            if ($role_name==config('role.acs')){

                $pending_total_approvals=$pending_total_approvals ->whereIN('activity_mission.mission_id', function($query) use ($User_id)
                {
                                $query->select('activity_mission.mission_id')
                                      ->from('activity_mission')
                                      ->join('activities', 'activity_mission.activity_id', '=', 'activities.id')
                                      ->where('activities.name', 'LIKE', "Waiting Approval PL")
                                      ->where('activity_mission.created_by', '=', $User_id);
                });

            }elseif($role_name!=config('role.super_admin') && $role_name!=config('role.wb_admin') && $role_name!=config('role.ttl')){

                $pending_total_approvals=$pending_total_approvals ->whereIN('activity_mission.mission_id', function($query) use($User_id,$role_name)
                {
                                $query->select('activity_mission.mission_id')
                                      ->from('activity_mission')
                                      ->join('activities', 'activity_mission.activity_id', '=', 'activities.id')
                                      ->where('activities.name', 'LIKE', "Mission Approval $role_name")
                                      ->where('activity_mission.created_by', '=', $User_id);
                });

            }

            $pending_total_approvals =$pending_total_approvals->where('activities.name', 'LIKE', "Government Waiting Mission Clearance ERD")
                                      ->where('activity_mission.created_at', '>=', $today)
                                      ->where('activity_mission.created_at', '<', $tomorrow)
                                      ->distinct('activity_mission.mission_id')
                                      ->count();



            if(!empty($pending_total_approvals)){
                return $pending_total_approvals;
            }else{
                return 0;
            }

        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }

    }




    /**Get Total  approved from  ERD Today  */
    public function get_total_erd_approved_mission(){
        try {

            $role_name = Auth::user()->roles->first()->name;
            $User_id = Auth::user()->id;
            $today=date("Y-m-d 00:00:00");
            $tomorrow = date("Y-m-d 00:00:00", strtotime("+1 day"));

                $pending_total_erd_approvals = \DB::table('activity_mission')
                        ->join('activities', 'activity_mission.activity_id', '=', 'activities.id')
                        ->select('activity_mission.mission_id');
            if ($role_name==config('role.acs')){

                $pending_total_erd_approvals=$pending_total_erd_approvals ->whereIN('activity_mission.mission_id', function($query) use ($User_id)
                {
                    $query->select('activity_mission.mission_id')
                        ->from('activity_mission')
                        ->join('activities', 'activity_mission.activity_id', '=', 'activities.id')
                        ->where('activities.name', 'LIKE', "Waiting Approval PL")
                        ->where('activity_mission.created_by', '=', $User_id);
                });

            }elseif($role_name!=config('role.super_admin') && $role_name!=config('role.wb_admin') && $role_name!=config('role.ttl')){

                $pending_total_erd_approvals=$pending_total_erd_approvals ->whereIN('activity_mission.mission_id', function($query) use($User_id,$role_name)
                {
                    $query->select('activity_mission.mission_id')
                        ->from('activity_mission')
                        ->join('activities', 'activity_mission.activity_id', '=', 'activities.id')
                        ->where('activities.name', 'LIKE', "Mission Approval $role_name")
                        ->where('activity_mission.created_by', '=', $User_id);
                });

            }

                $pending_total_erd_approvals =$pending_total_erd_approvals->where('activities.name', 'LIKE', "Government Final Approval ERD")
                       ->where('activity_mission.created_at', '>=', $today)
                       ->where('activity_mission.created_at', '<', $tomorrow)
                       ->distinct('activity_mission.mission_id')
                       ->count();


            if(!empty($pending_total_erd_approvals)){
                return $pending_total_erd_approvals;
            }else{
                return 0;
            }

        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }

    }



/** get_visiting_mission_staff **/
    public function get_visiting_mission_staff(){
        try {

            $today = date('Y-m-d 00:00:00');
            $visiting_mission_staff_count=\DB::table('member_mission')
                ->select('member_mission.member_id')
                ->join('members', 'member_mission.member_id', '=', 'members.id')
                ->join('member_types', 'members.member_type_id', '=', 'member_types.id')
                ->join('missions', 'member_mission.mission_id', '=', 'missions.id')
                ->where('member_types.name', 'LIKE', config('member_types.visiting_mission_staff'))
                ->whereNull('members.deleted_at')
                ->whereNull('missions.deleted_at')
                ->where('missions.is_draft',0)
                ->where('missions.activity_id', '>=', '22')
                ->where('missions.start_date', '<=', $today)
                ->where('missions.end_date', '>=', $today)
                ->groupBy('member_mission.member_id')
                ->get()
                ->count();


//            $visiting_mission_staff_count=\DB::table('members')
//                ->join('member_types', 'members.member_type_id', '=', 'member_types.id')
//                ->where('member_types.name', 'LIKE', config('member_types.visiting_mission_staff'))
//                ->whereNull('members.deleted_at')
//                ->count();
//            $visiting_mission_staff_last_update=\DB::table('members')
//                ->join('member_types', 'members.member_type_id', '=', 'member_types.id')
//                ->where('member_types.name', 'LIKE', config('member_types.visiting_mission_staff'))
//                ->whereNull('members.deleted_at')
//                ->orderBy('members.updated_at','desc')
//                ->first();

            $visiting_mission_staff_last_update=\DB::table('member_mission')
                ->join('members', 'member_mission.member_id', '=', 'members.id')
                ->join('member_types', 'members.member_type_id', '=', 'member_types.id')
                ->join('missions', 'member_mission.mission_id', '=', 'missions.id')
                ->where('member_types.name', 'LIKE', config('member_types.visiting_mission_staff'))
                ->whereNull('members.deleted_at')
                ->whereNull('missions.deleted_at')
                ->where('missions.is_draft',0)
                ->where('missions.activity_id', '>=', '22')
                ->where('missions.start_date', '<=', $today)
                ->where('missions.end_date', '>=', $today)
                ->orderBy('member_mission.updated_at','desc')
                ->first();

            if(!empty($visiting_mission_staff_count)){
                 $visiting_mission_staff['count']=$visiting_mission_staff_count;
            }else{
                $visiting_mission_staff['count']=0;

            }
            if(!empty($visiting_mission_staff_last_update)){
                $visiting_mission_staff['last_updated']=$visiting_mission_staff_last_update->updated_at;
            }else{
                $visiting_mission_staff['last_updated']='';

            }

            return $visiting_mission_staff;
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }

    }




    /** Get CO Staff On Mission **/
    public function get_co_mission_staff(){
        try {

            $today = date('Y-m-d 00:00:00');
            $co_mission_staff_count=\DB::table('member_mission')
                ->select('member_mission.member_id')
                ->join('members', 'member_mission.member_id', '=', 'members.id')
                ->join('member_types', 'members.member_type_id', '=', 'member_types.id')
                ->join('missions', 'member_mission.mission_id', '=', 'missions.id')
                ->where('member_types.name', 'LIKE', config('member_types.co_staff_on_mission'))
                ->whereNull('members.deleted_at')
                ->whereNull('missions.deleted_at')
                ->where('missions.is_draft',0)
                ->where('missions.activity_id', '>=', '22')
                ->where('missions.start_date', '<=', $today)
                ->where('missions.end_date', '>=', $today)
                ->groupBy('member_mission.member_id')
                ->get()
                ->count();

//            $co_mission_staff_count=\DB::table('members')
//                ->join('member_types', 'members.member_type_id', '=', 'member_types.id')
//                ->where('member_types.name', 'LIKE', config('member_types.co_staff_on_mission'))
//                ->whereNull('members.deleted_at')
//                ->count();

//            $co_mission_staff_last_update=\DB::table('members')
//                ->join('member_types', 'member_types.id', '=', 'members.member_type_id')
//                ->where('member_types.name', 'LIKE', config('member_types.co_staff_on_mission'))
//                ->whereNull('members.deleted_at')
//                ->orderBy('members.updated_at','desc')
//                ->first();
            $co_mission_staff_last_update=\DB::table('member_mission')
                ->join('members', 'member_mission.member_id', '=', 'members.id')
                ->join('member_types', 'members.member_type_id', '=', 'member_types.id')
                ->join('missions', 'member_mission.mission_id', '=', 'missions.id')
                ->where('member_types.name', 'LIKE', config('member_types.co_staff_on_mission'))
                ->whereNull('members.deleted_at')
                ->whereNull('missions.deleted_at')
                ->where('missions.is_draft',0)
                ->where('missions.activity_id', '>=', '22')
                ->where('missions.start_date', '<=', $today)
                ->where('missions.end_date', '>=', $today)
                ->orderBy('member_mission.updated_at','desc')
                ->first();


            if(!empty($co_mission_staff_count)){
                $co_mission_staff['count']=$co_mission_staff_count;
            }else{
                $co_mission_staff['count']=0;

            }
            if(!empty($co_mission_staff_last_update)){
                $co_mission_staff['last_updated']=$co_mission_staff_last_update->updated_at;
            }else{
                $co_mission_staff['last_updated']='';

            }

            return $co_mission_staff;
        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }

    }






    /** get total staff currently on mission **/
    public function get_total_staff_currently_on_mission(){
        try {
            $today = date('Y-m-d 00:00:00');

            $mission_staff_count=\DB::table('member_mission')
                ->select('member_mission.member_id')
                ->join('members', 'member_mission.member_id', '=', 'members.id')
                ->join('missions', 'member_mission.mission_id', '=', 'missions.id')
                ->whereNull('members.deleted_at')
                ->whereNull('missions.deleted_at')
                ->where('missions.is_draft',0)
                ->where('missions.activity_id', '>=', '22')
                ->where('missions.start_date', '<=', $today)
                ->where('missions.end_date', '>=', $today)
                ->groupBy('member_mission.member_id')
                ->get()
                ->count();



            $mission_staff_last_update=\DB::table('member_mission')
                ->join('members', 'member_mission.member_id', '=', 'members.id')
                ->join('member_types', 'members.member_type_id', '=', 'member_types.id')
                ->join('missions', 'member_mission.mission_id', '=', 'missions.id')
                ->whereNull('members.deleted_at')
                ->whereNull('missions.deleted_at')
                ->where('missions.is_draft',0)
                ->where('missions.activity_id', '>=', '22')
                ->where('missions.start_date', '<=', $today)
                ->where('missions.end_date', '>=', $today)
                ->orderBy('member_mission.updated_at','desc')
                ->first();
            if(!empty($mission_staff_count)){
                $total_mission_staff['count']=$mission_staff_count;
            }else{
                $total_mission_staff['count']=0;

            }
            if(!empty($mission_staff_last_update)){
                $total_mission_staff['last_updated']=$mission_staff_last_update->updated_at;
            }else{
                $total_mission_staff['last_updated']='';

            }
            return $total_mission_staff;

        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }

    }



    /** get  on going mission **/
    public function get_on_going_mission(){
        try {
            $today = date('Y-m-d 00:00:00');

            // activity_id 22==finalized the mission
            $on_going_mission=\DB::table('missions')
                                ->where('missions.activity_id', '>=', '22')
                                ->where('missions.start_date', '<=', $today)
                                ->where('missions.end_date', '>=', $today)
                                ->count();

            if(!empty($on_going_mission)){
                return $on_going_mission;
            }else{
                return 0;
            }

        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }

    }



    /** get waiting approval mission **/
    public function get_no_of_waiting_approval_mission(){
        try {
            $today = date('Y-m-d 00:00:00');

            $waiting_approval_mission=\DB::table('missions')
                                        ->whereIn('missions.activity_id', [4,5,6,8,9,10,12,12,14,16,17,19,20,21])
                                        ->where('missions.start_date', '<=', $today)
                                        ->where('missions.end_date', '>=', $today)
                                        ->count();

            if(!empty($waiting_approval_mission)){
                return $waiting_approval_mission;
            }else{
                return 0;
            }

        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }

    }



    /** get  Finalized mission requests for clearance **/
    public function getGovernmentClearanceIssuedCount($activityName)
    {
        try {
            $role_name = Auth::user()->roles->first()->name;
            $issuedClearance = \DB::table('missions')
                ->join('activity_mission', 'missions.id', '=', 'activity_mission.mission_id')
                ->join('activities', 'activity_mission.activity_id', '=', 'activities.id');

                if($role_name!=config('role.super_admin') && $role_name!=config('role.wb_admin')) {
                    $issuedClearance=$issuedClearance ->where('activity_mission.created_by', '=', Auth::user()->id);
                }

                $issuedClearance=$issuedClearance->where('activities.name', '=', $activityName)
                ->where('missions.is_draft', '=', '0')
                ->select(['missions.id','mission_name', 'missions.start_date'])
                ->count();
            if(!empty($issuedClearance)){
                return $issuedClearance;
            }else{
                return 0;
            }

        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }
    }



    /** get  ready_for_clearance_erdc **/
    public function no_of_ready_for_clearance_erdc($activityName)
    {
        try {

            $role_name = Auth::user()->roles->first()->name;
            $issuedClearance = \DB::table('missions')
                ->join('activity_mission', 'missions.id', '=', 'activity_mission.mission_id')
                ->join('activities', 'activity_mission.activity_id', '=', 'activities.id');

                if($role_name!=config('role.super_admin') && $role_name!=config('role.wb_admin') && $role_name!=config('role.ttl')) {
                    $issuedClearance=$issuedClearance->where('activity_mission.created_by', '=', Auth::user()->id);
                }

            $issuedClearance=$issuedClearance->where('activities.name', '=', $activityName)
                ->where('missions.activity_id', '<=', '21')
                ->where('missions.is_draft', '=', '0')
                ->select(['missions.id','mission_name', 'missions.start_date'])
                ->count();
            if(!empty($issuedClearance)){
                return $issuedClearance;
            }else{
                return 0;
            }

        } catch (\Exception $e) {
            $errorArr = array('user_id'=>Auth::user()->id, 'msg' => "No data", 'error' => $e->getMessage());
            \Log::error($errorArr);
        }
    }
}
