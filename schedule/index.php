<?php
require_once '../Init.php';

$user = new User();
if($user->isLoggedIn()) {
    if($user->data()->defaultView == 0) {
        $userRows = DB::getInstance()->getAssoc("SELECT id, full_name, work_group FROM users");
        foreach($userRows->results() as $results) {
            $user_rows[] = $results;
        }
    } elseif($user->data()->defaultView == 1) {
        $userRows = DB::getInstance()->getAssoc("SELECT id, full_name, work_group FROM users WHERE work_group LIKE 'Field%'");
        foreach($userRows->results() as $results) {
            $user_rows[] = $results;
        }
    } elseif($user->data()->defaultView == 2) {
        $userRows = DB::getInstance()->getAssoc("SELECT id, full_name, work_group FROM users WHERE work_group LIKE 'Office%'");
        foreach($userRows->results() as $results) {
            $user_rows[] = $results;
        }
    }
    //First page load
    if(empty($_POST)) {
	//User has not selected a default date
        if($user->data()->defaultDate == NULL) {
            $monday = date('Y-m-d',strtotime('this week monday'));
            $tuesday = date('Y-m-d',strtotime('this week tuesday'));
            $wednesday = date('Y-m-d',strtotime('this week wednesday'));
            $thursday = date('Y-m-d',strtotime('this week thursday'));
            $friday = date('Y-m-d',strtotime('this week friday'));
            //$saturday = date('Y-m-d',strtotime('this week saturday'));

            $next_monday = date('Y-m-d',strtotime($monday.'+7 days'));
            $next_tuesday = date('Y-m-d',strtotime($tuesday.'+7 days'));
            $next_wednesday = date('Y-m-d',strtotime($wednesday.'+7 days'));
            $next_thursday = date('Y-m-d',strtotime($thursday.'+7 days'));
            $next_friday = date('Y-m-d',strtotime($friday.'+7 days'));
            //$next_saturday = date('Y-m-d',strtotime($saturday.'+7 days'));

            $third_monday = date('Y-m-d',strtotime($monday.'+14 days'));
            $third_tuesday = date('Y-m-d',strtotime($tuesday.'+14 days'));
            $third_wednesday = date('Y-m-d',strtotime($wednesday.'+14 days'));
            $third_thursday = date('Y-m-d',strtotime($thursday.'+14 days'));
            $third_friday = date('Y-m-d',strtotime($friday.'+14 days'));
            //$third_saturday = date('Y-m-d',strtotime($saturday.'+14 days'));

            $fourth_monday = date('Y-m-d',strtotime($monday.'+21 days'));
            $fourth_tuesday = date('Y-m-d',strtotime($tuesday.'+21 days'));
            $fourth_wednesday = date('Y-m-d',strtotime($wednesday.'+21 days'));
            $fourth_thursday = date('Y-m-d',strtotime($thursday.'+21 days'));
            $fourth_friday = date('Y-m-d',strtotime($friday.'+21 days'));
            //$fourth_saturday = date('Y-m-d',strtotime($saturday.'+21 days'));
        } else {
	//User has selected a default date
            $monday = date('Y-m-d',strtotime('monday this week'.$user->data()->defaultDate));
            $tuesday = date('Y-m-d',strtotime('tuesday this week'.$user->data()->defaultDate));
            $wednesday = date('Y-m-d',strtotime('wednesday this week'.$user->data()->defaultDate));
            $thursday = date('Y-m-d',strtotime('thursday this week'.$user->data()->defaultDate));
            $friday = date('Y-m-d',strtotime('friday this week'.$user->data()->defaultDate));
            //$saturday = date('Y-m-d',strtotime('saturday this week'.$user->data()->defaultDate));


            $next_monday = date('Y-m-d',strtotime($monday.'+7 days'));
            $next_tuesday = date('Y-m-d',strtotime($tuesday.'+7 days'));
            $next_wednesday = date('Y-m-d',strtotime($wednesday.'+7 days'));
            $next_thursday = date('Y-m-d',strtotime($thursday.'+7 days'));
            $next_friday = date('Y-m-d',strtotime($friday.'+7 days'));
            //$next_saturday = date('Y-m-d',strtotime($saturday.'+7 days'));

            $third_monday = date('Y-m-d',strtotime($monday.'+14 days'));
            $third_tuesday = date('Y-m-d',strtotime($tuesday.'+14 days'));
            $third_wednesday = date('Y-m-d',strtotime($wednesday.'+14 days'));
            $third_thursday = date('Y-m-d',strtotime($thursday.'+14 days'));
            $third_friday = date('Y-m-d',strtotime($friday.'+14 days'));
            //$third_saturday = date('Y-m-d',strtotime($saturday.'+14 days'));

            $fourth_monday = date('Y-m-d',strtotime($monday.'+21 days'));
            $fourth_tuesday = date('Y-m-d',strtotime($tuesday.'+21 days'));
            $fourth_wednesday = date('Y-m-d',strtotime($wednesday.'+21 days'));
            $fourth_thursday = date('Y-m-d',strtotime($thursday.'+21 days'));
            $fourth_friday = date('Y-m-d',strtotime($friday.'+21 days'));
            //$fourth_saturday = date('Y-m-d',strtotime($saturday.'+21 days'));
        }
    } else {
    	//After submitting a date
        if($_POST['date']) {
            $day = date('d', strtotime($_POST['date']));
            $month = date('m', strtotime($_POST['date']));
            $year = date('Y', strtotime($_POST['date']));
            $defaultDate = $year.'-'.$month.'-'.$day;

            $schedule = DB::getInstance()->update('users', $user->data()->id, array(
                'defaultDate' => $defaultDate
            ));

            $monday = date('Y-m-d',strtotime('this week monday', mktime(0,0,0, $month, $day, $year)));
            $tuesday = date('Y-m-d',strtotime('this week tuesday', mktime(0,0,0, $month, $day, $year)));
            $wednesday = date('Y-m-d',strtotime('this week wednesday', mktime(0,0,0, $month, $day, $year)));
            $thursday = date('Y-m-d',strtotime('this week thursday', mktime(0,0,0, $month, $day, $year)));
            $friday = date('Y-m-d',strtotime('this week friday', mktime(0,0,0, $month, $day, $year)));
            //$saturday = date('Y-m-d',strtotime('this week saturday', mktime(0,0,0, $month, $day, $year)));

            $next_monday = date('Y-m-d',strtotime($monday.'+7 days', mktime(0,0,0, $month, $day, $year)));
            $next_tuesday = date('Y-m-d',strtotime($tuesday.'+7 days', mktime(0,0,0, $month, $day, $year)));
            $next_wednesday = date('Y-m-d',strtotime($wednesday.'+7 days', mktime(0,0,0, $month, $day, $year)));
            $next_thursday = date('Y-m-d',strtotime($thursday.'+7 days', mktime(0,0,0, $month, $day, $year)));
            $next_friday = date('Y-m-d',strtotime($friday.'+7 days', mktime(0,0,0, $month, $day, $year)));
            //$next_saturday = date('Y-m-d',strtotime($saturday.'+7 days', mktime(0,0,0, $month, $day, $year)));

            $third_monday = date('Y-m-d',strtotime($monday.'+14 days', mktime(0,0,0, $month, $day, $year)));
            $third_tuesday = date('Y-m-d',strtotime($tuesday.'+14 days', mktime(0,0,0, $month, $day, $year)));
            $third_wednesday = date('Y-m-d',strtotime($wednesday.'+14 days', mktime(0,0,0, $month, $day, $year)));
            $third_thursday = date('Y-m-d',strtotime($thursday.'+14 days', mktime(0,0,0, $month, $day, $year)));
            $third_friday = date('Y-m-d',strtotime($friday.'+14 days', mktime(0,0,0, $month, $day, $year)));
            //$third_saturday = date('Y-m-d',strtotime($saturday.'+14 days', mktime(0,0,0, $month, $day, $year)));

            $fourth_monday = date('Y-m-d',strtotime($monday.'+21 days', mktime(0,0,0, $month, $day, $year)));
            $fourth_tuesday = date('Y-m-d',strtotime($tuesday.'+21 days', mktime(0,0,0, $month, $day, $year)));
            $fourth_wednesday = date('Y-m-d',strtotime($wednesday.'+21 days', mktime(0,0,0, $month, $day, $year)));
            $fourth_thursday = date('Y-m-d',strtotime($thursday.'+21 days', mktime(0,0,0, $month, $day, $year)));
            $fourth_friday = date('Y-m-d',strtotime($friday.'+21 days', mktime(0,0,0, $month, $day, $year)));
            //$fourth_saturday = date('Y-m-d',strtotime($saturday.'+21 days', mktime(0,0,0, $month, $day, $year)));
        } else {
	//If another post is submited...just incase
            $monday = date('Y-m-d',strtotime('monday this week'.$user->data()->defaultDate));
            $tuesday = date('Y-m-d',strtotime('tuesday this week'.$user->data()->defaultDate));
            $wednesday = date('Y-m-d',strtotime('wednesday this week'.$user->data()->defaultDate));
            $thursday = date('Y-m-d',strtotime('thursday this week'.$user->data()->defaultDate));
            $friday = date('Y-m-d',strtotime('friday this week'.$user->data()->defaultDate));
            //$saturday = date('Y-m-d',strtotime('saturday this week'.$user->data()->defaultDate));

            $next_monday = date('Y-m-d',strtotime($monday.'+7 days'));
            $next_tuesday = date('Y-m-d',strtotime($tuesday.'+7 days'));
            $next_wednesday = date('Y-m-d',strtotime($wednesday.'+7 days'));
            $next_thursday = date('Y-m-d',strtotime($thursday.'+7 days'));
            $next_friday = date('Y-m-d',strtotime($friday.'+7 days'));
            //$next_saturday = date('Y-m-d',strtotime($saturday.'+7 days'));

            $third_monday = date('Y-m-d',strtotime($monday.'+14 days'));
            $third_tuesday = date('Y-m-d',strtotime($tuesday.'+14 days'));
            $third_wednesday = date('Y-m-d',strtotime($wednesday.'+14 days'));
            $third_thursday = date('Y-m-d',strtotime($thursday.'+14 days'));
            $third_friday = date('Y-m-d',strtotime($friday.'+14 days'));
            //$third_saturday = date('Y-m-d',strtotime($saturday.'+14 days'));
            
	    $fourth_monday = date('Y-m-d',strtotime($monday.'+21 days'));
            $fourth_tuesday = date('Y-m-d',strtotime($tuesday.'+21 days'));
            $fourth_wednesday = date('Y-m-d',strtotime($wednesday.'+21 days'));
            $fourth_thursday = date('Y-m-d',strtotime($thursday.'+21 days'));
            $fourth_friday = date('Y-m-d',strtotime($friday.'+21 days'));
            //$fourth_saturday = date('Y-m-d',strtotime($saturday.'+21 days'));
        }
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
        $tech = $user_rows[$i]['full_name'];

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
    $page->setTitle('Schedule');
    $page->startBody();
    echo $page->render('../includes/menu.php');
    ?>


    <div id="content">
    <div id="contentHeader" style="float:left"></div>
    <div class="container">
    <div class="row">
    <div class="grid-24" align="center">
        <div id="toggleLGN">
            <button class="btn-lgn btn-brown">Non-Emergency</button>
            <button class="btn-lgn btn-red">Emergency</button>
            <button class="btn-lgn btn-green">PM</button>
            <button class="btn-lgn btn-blue">Installed</button>
            <button class="btn-lgn btn-orange">Holiday</button>
            <button class="btn-lgn btn-purple">PTO</button>
            <button class="btn-lgn btn-primary">T&M</button>
            <button class="btn-lgn btn-black">Training</button>
            <button class="btn-lgn btn-other">Other</button>
        </div>
    </div>
    <div class="grid-24" align="center">
        <a href="#week1"><button class="btn-lgn btn-black">Week 1</button></a>
        <a href="#week2"><button class="btn-lgn btn-black">Week 2</button></a>
        <a href="#week3"><button class="btn-lgn btn-black">Week 3</button></a>
        <a href="#week4"><button class="btn-lgn btn-black">Week 4</button></a>
        <a id="displayText" href="javascript:toggle();"><button class="btn-lgn btn-primary">Other Week</button></a>
        <div id="toggleText" style="display: none">
            <form action="" method="post" id="schedule">
                <div id="datepicker"></div>
                <input type="hidden" id="alternate" name="date"/>
                <button type="submit" name="viewSchedule" class="btn btn-primary btn-small">View Schedule</button>
            </form>
        </div>
    </div>
    <div class="grid-24">
    <?php for ($z=1; $z<5; $z++) { ?>
        <div class="widget">
        <div class="widget widget-table">
        <div class="widget-header">
            <span class="icon-list"></span>
            <h3><a name="week<?php echo escape($z); ?>" class="widget-header h3">Week <?php echo escape($z); ?></a></h3>
        </div>
        <div class="widget-content">
        <table class="table table-bordered table-striped data-table table-sch displayed">
        <thead>
        <tr>
            <th width="100px">Employee</th>
            <th width="100px">Group</th>
            <th width="200px">Mon <?php echo date('m/d',strtotime($$days[$z][0])); ?></th>
            <th width="200px">Tue <?php echo date('m/d',strtotime($$days[$z][1])); ?></th>
            <th width="200px">Wed <?php echo date('m/d',strtotime($$days[$z][2])); ?></th>
            <th width="200px">Thurs <?php echo date('m/d',strtotime($$days[$z][3])); ?></th>
            <th width="200px">Fri <?php echo date('m/d',strtotime($$days[$z][4])); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php for ($i=0; $i<count($user_rows); $i++) {
            $tech = $user_rows[$i]['full_name']; ?>
            <tr class="gradeA"><td>
                    <a href="../user/view.php?id='<?php echo escape($user_rows[$i]['id']);?>">
                        <?php echo $tech; ?>
                    </a>
                </td>
                <td><?php echo escape($user_rows[$i]['work_group']); ?></td>
                <?php
                //Scheduled Items for each User
                $rows = ${"sched_rows_$z"};
                foreach($days[$z] as $day => $key) { ?>
                <td>
                    <?php foreach ($rows[$tech] as $sched_item) {
                        if ($sched_item['date'] == $$key){
                            $url = $sched_item['id']; ?>
                            <a href="notification.php?id=<?php echo $url; ?>"
                               title="<?php echo $sched_item['notes']."&#10;";
                            echo date('m/d/y',strtotime($sched_item['date']));
                            ?>">
                                <button class="<?php echo $sched_item['type'];?>">
                                    <?php if ($sched_item['isConfirmed'] == 1) { ?>
                                        <div style="float: left; position: absolute;top: 7px; margin-right: 20px;">
                                            <span class="menu-iphone"></span>
                                        </div>
                                    <?php } if ($sched_item['callConfirmed'] == 1) { ?>
                                        <div style="float: left; position: absolute;top: 7px; margin-left: 20px;">
                                            <span class="menu-check" style="margin-left: 20px;"></span>
                                        </div>
                                    <?php } if ($sched_item['isLocked'] == 1) { ?>
                                        <div style="float: left; position: absolute; top: 7px;">
                                            <span class="menu-lock-stroke" style="margin-left: 20px;"></span>
                                        </div>
                                    <?php } ?>
                                    <div style="float: right; text-align: right; width: 75%">
                                        <?php
                                        echo $sched_item['site']."<br/>";
                                        echo $sched_item['nid']."<br/>";
                                        echo $sched_item['start_time']."-".$sched_item['stop_time'];
                                        ?>
                                    </div></button></a><br>
                        <?php }
                    }
                    echo "</td>";
                    }
                    echo "</tr>";
                    } ?>
            </tbody>
            </table>
            </div>
            </div>
            </div>
        <?php } ?>
        </div>
        </div>
        </div>
        </div>

        <?php
        $page->endBody();
        echo $page->render('../includes/template.php');
    } else {
        Redirect::to('../login/');
    }
