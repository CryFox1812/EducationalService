<?php

interface JournalServiceInterface
{
    public function get_grades_list($data);

    public function get_attendance_list($data);

    public function set_grades_list($data);

    public function set_attendance_list($data);

    public function average_grade($data);

    public function total_attendance($data);
}

?>