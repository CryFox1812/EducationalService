<?php
interface ScheduleServiceInterface
{
    public function get_discipline_list($token);

    public function get_schedule_list($data, $token);

    public function get_schedule_code($token);

    public function set_schedule_code($data, $token);
}

?>