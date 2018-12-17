<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\ClearanceInterface;
use App\Repositories\Contracts\DashboardInterface;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    protected $dashboard;
    protected $clearance;


    public function __construct(
        DashboardInterface $dashboard,
        ClearanceInterface $clearance
    ) {
        $this->dashboard = $dashboard;
        $this->clearance = $clearance;
        $this->middleware('auth');
    }

    public function index()
    {
        try {
           $role_name = Auth::user()->roles->first()->name;
           $no_of_pending_approvals = $this->dashboard->get_pending_wb_approvals();
           $no_of_erd_pending_approvals = $this->dashboard->get_pending_erd_approvals();
           $no_of_total_approved = $this->dashboard->get_total_approved_mission();
           $no_of_total_erd_approved = $this->dashboard->get_total_erd_approved_mission();
           $no_of_visiting_mission_staff = $this->dashboard->get_visiting_mission_staff();
           $no_of_co_mission_staff = $this->dashboard->get_co_mission_staff();
           $no_of_total_staff= $this->dashboard->get_total_staff_currently_on_mission();
           $no_of_on_going_mission= $this->dashboard->get_on_going_mission();
           $no_of_waiting_approval_mission= $this->dashboard->get_no_of_waiting_approval_mission();
           $no_of_erd_pending_request= $this->clearance->getErdClearancePendingCount('Government Waiting Mission Clearance ERD');
           $no_of_ready_for_clearance= $this->clearance->getErdClearancePendingCount('Government Waiting Mission Final Clearance ERD');
           $no_of_finalized_clearance= $this->dashboard->getGovernmentClearanceIssuedCount("Government Final Approval ".config('role.erd'));
           $no_of_erdc_pending_request= $this->clearance->getErdClearancePendingCount('Government Waiting Mission Clearance ERDC');
           $no_of_ready_for_clearance_erdc= $this->dashboard->no_of_ready_for_clearance_erdc("Government Waiting Mission Final Clearance ".config('role.erd'));
            return view('dashboard.index',compact([
                                                            'role_name',
                                                            'no_of_pending_approvals',
                                                            'no_of_erd_pending_approvals',
                                                            'no_of_total_approved',
                                                            'no_of_total_erd_approved',
                                                            'no_of_visiting_mission_staff',
                                                            'no_of_co_mission_staff',
                                                            'no_of_total_staff',
                                                            'no_of_on_going_mission',
                                                            'no_of_waiting_approval_mission',
                                                            'no_of_erd_pending_request',
                                                            'no_of_ready_for_clearance',
                                                            'no_of_finalized_clearance',
                                                            'no_of_erdc_pending_request',
                                                            'no_of_ready_for_clearance_erdc'
                                                        ]));
        } catch (\Exception $e) {
            \Log::error(array('user_id' => Auth::user()->id, 'msg' => "Failed to redirect to the home page.", "error" => $e->getMessage()));
        }
    }
}
