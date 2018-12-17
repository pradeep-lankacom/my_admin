<?php

namespace App\Repositories\Contracts;

interface DashboardInterface
{
    public function get_pending_wb_approvals();

    public function get_pending_erd_approvals();

    public function get_total_approved_mission();

    public function get_total_erd_approved_mission();

    public function get_visiting_mission_staff();

    public function get_co_mission_staff();

    public function get_total_staff_currently_on_mission();

    public function get_on_going_mission();

    public function get_no_of_waiting_approval_mission();

    public function getGovernmentClearanceIssuedCount($activityName);

    public function no_of_ready_for_clearance_erdc($activityName);
}
