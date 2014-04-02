<?php
require_once '../Init.php';

$user = new User();
$page = new Page;
$page->setTitle('Remove User');
$page->startBody();
echo $page->render('../includes/menu.php');

if($user->isLoggedIn()) {
    if ($user->hasPermission('edit')) {

        $userRows = DB::getInstance()->getAssoc("SELECT * FROM users");
        foreach($userRows->results() as $results) {
            $user_rows[] = $results;
        }

        if(Input::exists()) {
            if(Token::check(Input::get('token'))) {
                foreach ($_POST['checkbox'] as $id) {
                    DB::getInstance()->delete('users', array('id', '=', $id));
                }
            }
            Redirect::to('../user/');
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
                                    <h3 class="icon chart">Remove Employees</h3>
                                </div>
                                <div class="widget-content">
                                    <table class="table table-bordered table-striped data-table table-sch">
                                        <thead>
                                        <tr>
                                            <th>Check</th>
                                            <th>Employee</th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                        <?php
                                        if(!empty($user_rows)) {
                                            foreach ($user_rows as $row) {
                                                echo '<tr class="gradeA">';
                                                echo '<td width="1%"><input name="checkbox[]" type="checkbox" id="checkbox[]" value="'.$row['id'].'"></td>';
                                                echo '<td>'.htmlentities($row['full_name'], ENT_QUOTES, 'UTF-8').'</td>';
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
                <button type="submit" class="btn btn-primary" tabindex="3" name="delete" id="delete">Delete Employee</button>
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