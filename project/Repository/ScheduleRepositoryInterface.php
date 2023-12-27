<?php

interface ScheduleRepositoryInterface
{
    public function get_disciplines_list($group_id);

    public function get_schedule_list($group_id, $discipline, $startDate, $endDate);

    public function get_schedule_code($schedule_id);

    public function get_schedule_by_professor($professor_id, $current_time);

    public function get_schedule_by_group($group_id, $current_time);
}

?>