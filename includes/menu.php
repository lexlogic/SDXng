<?php
require_once '../Init.php';
$user = new User();
?>

<div id="sidebar">
    <ul id="mainNav">
        <?php
        $pages = array(
            '../dashboard/' => array('Dashboard' => 'home'),
            '../schedule/' => array('Schedule' => 'document-alt-stroke'),
            '../user/' => array('Employees' => 'article'),
            '../sites/' => array('Sites' => 'map-pin-fill'),
            '../reports/' => array('Reports' => 'icon-chart'),
        ) ;
        //$url = $_SERVER['SERVER_NAME'] . dirname(FILE);
        $script = $_SERVER['SCRIPT_NAME'];
        $i = "..".dirname($script)."/";

        foreach ($pages as $filename => $pageTitle) {
            foreach ($pageTitle as $pages => $images) {
                if ($i == $filename) {
                    $active = '<li id="navDashboard" class="nav active">';
                    $active .= '<a href="'.$filename.'">'.$pages.'</a>';
                    $active .= '</li>';
                    echo $active;
                }
                else {
                    $inactive = '<li id="navDashboard" class="nav">';
                    $inactive .= '<a href="'.$filename.'">'.$pages.'</a>';
                    $inactive .= '</li>';
                    echo $inactive;
                }
            }
        }
        if(isset($_POST['view'])) {
            $update = DB::getInstance()->update('users', $user->data()->id, array(
                'defaultView' => Input::get('view')
            ));
            Redirect::to('../schedule/');
        }
        if($user->data()->defaultView == 0) {
            $currentView = "Everyone";
        }
        if($user->data()->defaultView == 1) {
            $currentView = "Field Only";
        }
        if($user->data()->defaultView == 2) {
            $currentView = "Office Only";
        }
        ?>
        <li id="navDashboard" class="nav">
            <a href="<?php echo '../user/edit.php?id='.$user->data()->id;?>">Edit Profile</a>
        </li>

        <li id="navDashboard" class="nav">
            <a href="../login/logout.php">Logout</a>
        </li>
        <form action="" method="post" id="view" accept-charset="utf-8" class="form uniformForm">
            <li id="navDashboard" class="nav" style="text-align: center;">
                <div class="field-group" style="margin-bottom: -33px;">
                    <div class="field">
                        <select name="view" id="view" onchange="this.form.submit()">
                            <option value="<?php echo $user->data()->defaultView; ?>">Current View: <?php echo $currentView; ?></option>
                            <option value="1">Field Only</option>
                            <option value="2">Office Only</option>
                            <option value="0">Everyone</option>
                        </select>
                    </div>
                </div>
            </li>
        </form>
        <li id="navDashboard" class="nav">
            <?php
            if ($user->hasPermission('edit')) { ?>
                <a href="../schedule/new.php"><span class="btn-sch-add btn-green" style="height: 30px;margin-top: -10px;margin-bottom: -10px;padding-top: 10px;width: 205px;margin-left: -10px;">New Schedule</span></a>
                <a href="../schedule/remove.php"><span class="btn-sch-add btn-red" style="height: 30px;margin-top: -10px;margin-bottom: -10px;padding-top: 10px;width: 205px;margin-left: -10px;">Remove Schedule</span></a>
            <?php }?>
        </li>
    </ul>
</div>