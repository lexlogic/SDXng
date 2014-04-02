<?php
class Schedule {
    public function scheduleView($name, $start, $end){
        DB::getInstance()->query("SELECT * FROM sched WHERE full_name = ? AND date between ? and ?", array($name,$start,$end));
        return true;
    }
}