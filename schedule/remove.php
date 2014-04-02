<?php
require_once '../Init.php';

$user = new User();
$page = new Page;
$page->setTitle('Remove Notification');
$page->startBody();
echo $page->render('../includes/menu.php');

if($user->isLoggedIn()) {
    if ($user->hasPermission('edit')) {

        $start = date('Y-m-d',strtotime('last month'));
        $end = date('Y-m-d',strtotime($start.'+12 months'));

        $schedRows = DB::getInstance()->getAssoc("SELECT * FROM sched WHERE date between ? and ?", array($start, $end));
        foreach($schedRows->results() as $results) {
            $sched_rows[] = $results;
        }
        if(Input::exists()) {
            if(Token::check(Input::get('token'))) {
                foreach ($_POST['checkbox'] as $id) {
                    DB::getInstance()->delete('sched', array('id', '=', $id));
                }
            }
            Redirect::to('../schedule/');
        }
        ?>



        <div id="content">
            <div id="contentHeader"></div>
            <div class="container">
                <div class="grid-24">
                    <div class="row">
                        <div class="widget">
                            <form action="" method="post" class="form uniformForm" id="form">
                                <div class="widget widget-table">
                                    <div class="widget widget-table">
                                        <div class="widget-header">
                                            <span class="icon-list"></span>
                                            <h3 class="icon chart">Remove Schedule</h3>
                                        </div>
                                        <div class="widget-content">
                                            <table class="table table-bordered table-striped data-table table-sch">
                                                <thead>
                                                <tr>
                                                    <th>Check</th>
                                                    <th>Tech Assigned</th>
                                                    <th>Site Name</th>
                                                    <th>Date Scheduled</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if(!empty($sched_rows)) {
                                                    foreach ($sched_rows as $row) {
                                                        echo '<tr class="gradeA">';
                                                        echo '<td width="1%" align="center"><input name="checkbox[]" type="checkbox" id="checkbox[]" value="'.$row['id'].'"></td>';
                                                        echo '<td>'.escape($row['full_name']).'</td>';
                                                        echo '<td>'.escape($row['site']).'</td>';
                                                        echo '<td>'.date('m/d/Y',strtotime(escape($row['date']))).'</td>';
                                                        echo '</tr>';
                                                    }
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="login_actions">
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
                        <button type="submit" class="btn btn-primary" tabindex="3" name="delete" id="delete">Delete Schedule</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        $page->endBody();
        echo $page->render('../includes/template.php');
    } else {
        Redirect::to('../login/');
    }
}