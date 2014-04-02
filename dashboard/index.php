<?php
require_once '../Init.php';

$user = new User();
if($user->isLoggedIn()) {

    $userRows = DB::getInstance()->getAssoc("SELECT id, full_name, work_group FROM users WHERE full_name = ?", array($user->data()->full_name));
    foreach($userRows->results() as $results) {
        $user_rows[] = $results;
    }
    $tech = $user_rows[0]['full_name'];

    if(empty($_POST)) {
        $monday = date('Y-m-d',strtotime('this week monday'));
        $this_monday = date('Y-m-d',strtotime('this week monday'));
        $tuesday = date('Y-m-d',strtotime('this week tuesday'));
        $this_tuesday = date('Y-m-d',strtotime('this week tuesday'));
        $wednesday = date('Y-m-d',strtotime('this week wednesday'));
        $this_wednesday = date('Y-m-d',strtotime('this week wednesday'));
        $thursday = date('Y-m-d',strtotime('this week thursday'));
        $this_thursday = date('Y-m-d',strtotime('this week thursday'));
        $friday = date('Y-m-d',strtotime('this week friday'));
        $this_friday = date('Y-m-d',strtotime('this week friday'));
        //$saturday = date('Y-m-d',strtotime('this week saturday'));
        //$this_saturday = date('Y-m-d',strtotime('this week saturday'));

        $next_monday = date('Y-m-d',strtotime($this_monday.'+7 days'));
        $next_tuesday = date('Y-m-d',strtotime($this_tuesday.'+7 days'));
        $next_wednesday = date('Y-m-d',strtotime($this_wednesday.'+7 days'));
        $next_thursday = date('Y-m-d',strtotime($this_thursday.'+7 days'));
        $next_friday = date('Y-m-d',strtotime($this_friday.'+7 days'));
        //$next_saturday = date('Y-m-d',strtotime($this_saturday.'+7 days'));

        $third_monday = date('Y-m-d',strtotime($this_monday.'+14 days'));
        $third_tuesday = date('Y-m-d',strtotime($this_tuesday.'+14 days'));
        $third_wednesday = date('Y-m-d',strtotime($this_wednesday.'+14 days'));
        $third_thursday = date('Y-m-d',strtotime($this_thursday.'+14 days'));
        $third_friday = date('Y-m-d',strtotime($this_friday.'+14 days'));
        //$third_saturday = date('Y-m-d',strtotime($this_saturday.'+14 days'));

        $fourth_monday = date('Y-m-d',strtotime($this_monday.'+21 days'));
        $fourth_tuesday = date('Y-m-d',strtotime($this_tuesday.'+21 days'));
        $fourth_wednesday = date('Y-m-d',strtotime($this_wednesday.'+21 days'));
        $fourth_thursday = date('Y-m-d',strtotime($this_thursday.'+21 days'));
        $fourth_friday = date('Y-m-d',strtotime($this_friday.'+21 days'));
        //$fourth_saturday = date('Y-m-d',strtotime($this_saturday.'+21 days'));
    } else {
        $day = date('d', strtotime($_POST['date']));
        $month = date('m', strtotime($_POST['date']));
        $year = date('y', strtotime($_POST['date']));

        $monday = date('Y-m-d',strtotime('this week monday', mktime(0,0,0, $month, $day, $year)));
        $this_monday = date('Y-m-d',strtotime('this week monday', mktime(0,0,0, $month, $day, $year)));
        $tuesday = date('Y-m-d',strtotime('this week tuesday', mktime(0,0,0, $month, $day, $year)));
        $this_tuesday = date('Y-m-d',strtotime('this week tuesday', mktime(0,0,0, $month, $day, $year)));
        $wednesday = date('Y-m-d',strtotime('this week wednesday', mktime(0,0,0, $month, $day, $year)));
        $this_wednesday = date('Y-m-d',strtotime('this week wednesday', mktime(0,0,0, $month, $day, $year)));
        $thursday = date('Y-m-d',strtotime('this week thursday', mktime(0,0,0, $month, $day, $year)));
        $this_thursday = date('Y-m-d',strtotime('this week thursday', mktime(0,0,0, $month, $day, $year)));
        $friday = date('Y-m-d',strtotime('this week friday', mktime(0,0,0, $month, $day, $year)));
        $this_friday = date('Y-m-d',strtotime('this week friday', mktime(0,0,0, $month, $day, $year)));
        //$saturday = date('Y-m-d',strtotime('this week saturday', mktime(0,0,0, $month, $day, $year)));
        //$this_saturday = date('Y-m-d',strtotime('this week saturday', mktime(0,0,0, $month, $day, $year)));

        $next_monday = date('Y-m-d',strtotime($this_monday.'+7 days', mktime(0,0,0, $month, $day, $year)));
        $next_tuesday = date('Y-m-d',strtotime($this_tuesday.'+7 days', mktime(0,0,0, $month, $day, $year)));
        $next_wednesday = date('Y-m-d',strtotime($this_wednesday.'+7 days', mktime(0,0,0, $month, $day, $year)));
        $next_thursday = date('Y-m-d',strtotime($this_thursday.'+7 days', mktime(0,0,0, $month, $day, $year)));
        $next_friday = date('Y-m-d',strtotime($this_friday.'+7 days', mktime(0,0,0, $month, $day, $year)));
        //$next_saturday = date('Y-m-d',strtotime($this_saturday.'+7 days', mktime(0,0,0, $month, $day, $year)));

        $third_monday = date('Y-m-d',strtotime($this_monday.'+14 days', mktime(0,0,0, $month, $day, $year)));
        $third_tuesday = date('Y-m-d',strtotime($this_tuesday.'+14 days', mktime(0,0,0, $month, $day, $year)));
        $third_wednesday = date('Y-m-d',strtotime($this_wednesday.'+14 days', mktime(0,0,0, $month, $day, $year)));
        $third_thursday = date('Y-m-d',strtotime($this_thursday.'+14 days', mktime(0,0,0, $month, $day, $year)));
        $third_friday = date('Y-m-d',strtotime($this_friday.'+14 days', mktime(0,0,0, $month, $day, $year)));
        //$third_saturday = date('Y-m-d',strtotime($this_saturday.'+14 days', mktime(0,0,0, $month, $day, $year)));

        $fourth_monday = date('Y-m-d',strtotime($this_monday.'+21 days', mktime(0,0,0, $month, $day, $year)));
        $fourth_tuesday = date('Y-m-d',strtotime($this_tuesday.'+21 days', mktime(0,0,0, $month, $day, $year)));
        $fourth_wednesday = date('Y-m-d',strtotime($this_wednesday.'+21 days', mktime(0,0,0, $month, $day, $year)));
        $fourth_thursday = date('Y-m-d',strtotime($this_thursday.'+21 days', mktime(0,0,0, $month, $day, $year)));
        $fourth_friday = date('Y-m-d',strtotime($this_friday.'+21 days', mktime(0,0,0, $month, $day, $year)));
        //$fourth_saturday = date('Y-m-d',strtotime($this_saturday.'+21 days', mktime(0,0,0, $month, $day, $year)));
    }

    $days = array(
        '1' => array(
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday'
        ),
        '2' => array(
            'next_monday',
            'next_tuesday',
            'next_wednesday',
            'next_thursday',
            'next_friday'
        ),
        '3' => array(
            'third_monday',
            'third_tuesday',
            'third_wednesday',
            'third_thursday',
            'third_friday'
        ),
        '4' => array(
            'fourth_monday',
            'fourth_tuesday',
            'fourth_wednesday',
            'fourth_thursday',
            'fourth_friday'
        ),
    );

    for ($i=0; $i<count($user_rows); $i++) {

        $sched_rows_1[$tech] = array();
        $sched_rows_2[$tech] = array();
        $sched_rows_3[$tech] = array();
        $sched_rows_4[$tech] = array();

        $firstSchedule = DB::getInstance()->getAssoc("SELECT * FROM sched WHERE full_name = ? AND date between ? and ?", array(
            $tech, $monday, $friday));
        foreach($firstSchedule->results() as $results) {
            $sched_rows_1[$tech][] = $results;
        }

        $secondSchedule = DB::getInstance()->getAssoc("SELECT * FROM sched WHERE full_name = ? AND date between ? and ?", array(
            $tech, $next_monday, $next_friday));
        foreach($secondSchedule->results() as $results) {
            $sched_rows_2[$tech][] = $results;
        }

        $thirdSchedule = DB::getInstance()->getAssoc("SELECT * FROM sched WHERE full_name = ? AND date between ? and ?", array(
            $tech, $third_monday, $third_friday));
        foreach($thirdSchedule->results() as $results) {
            $sched_rows_3[$tech][] = $results;
        }

        $fourthSchedule = DB::getInstance()->getAssoc("SELECT * FROM sched WHERE full_name = ? AND date between ? and ?", array(
            $tech, $fourth_monday, $fourth_friday));
        foreach($fourthSchedule->results() as $results) {
            $sched_rows_4[$tech][] = $results;
        }
    }

    $page = new Page;
    $page->setTitle('Dashboard');
    $page->startBody();
    echo $page->render('../includes/menu.php');

    echo '<div id="content">';
    echo '<div id="contentHeader" style="float:left"></div>';
    echo '<div class="container">';
    echo '<div class="row">';
    echo '<div class="grid-24">';
    echo '<a id="displayText" href="javascript:toggle();"><button class="btn-lgn btn-primary">Other Week</button></a>';
    echo '<div id="toggleText" style="display: none">';
    echo '<form action="" method="post">';
    echo '<div id="datepicker"></div>';
    echo '<input type="hidden" id="alternate" name="date"/>';
    echo '<button type="submit" class="btn btn-primary btn-small">View Schedule</button>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
    echo '<div class="grid-24">';
        echo '<div class="widget">';
        echo '<div class="widget widget-table">';
        echo '<div class="widget-header">';
        echo '<span class="icon-list" style="top: 11px;"></span>';
        echo '<h3 style="top: 8px;">Hello, '.$user->data()->username.' Here is your schedule for this month.</h3>';
        echo '</div>';
        echo '<div class="widget-content">';
    for ($z=1; $z<5; $z++) {
        echo '<table class="table table-bordered table-striped table-sch displayed">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Monday '.date('m/d/Y',strtotime($$days[$z][0])).'</th>';
        echo '<th>Tuesday '.date('m/d/Y',strtotime($$days[$z][1])).'</th>';
        echo '<th>Wednesday '.date('m/d/Y',strtotime($$days[$z][2])).'</th>';
        echo '<th>Thursday '.date('m/d/Y',strtotime($$days[$z][3])).'</th>';
        echo '<th>Friday '.date('m/d/Y',strtotime($$days[$z][4])).'</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        echo '<tr class="gradeA">';
        $rows = ${"sched_rows_$z"};
            foreach($days[$z] as $day => $key) {
                echo "<td>";
                foreach ($rows[$tech] as $sched_item) {
                    if ($sched_item['date'] == $$key){
                        $url = $sched_item['id'];
                        echo '<a href="../schedule/notification.php?id='.$url.'">';
                        echo '<button class="'.$sched_item['type'].'">';
                        echo $sched_item['start_time']."-".$sched_item['stop_time']."<br/>";
                        echo $sched_item['site'];
                        echo "</button></a><br>";
                    }
                }
                echo "</td>";
            }
            echo "</tr>";
        echo '</tbody>';
        echo '</table>';
    }
        echo '</div>';
        echo '</div>';
        echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    $page->endBody();
    echo $page->render('../includes/template.php');
} else {
    Redirect::to('../login/');
}
