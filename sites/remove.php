<?php
require_once '../Init.php';

$user = new User();
$page = new Page;
$page->setTitle('Remove Sites');
$page->startBody();
echo $page->render('../includes/menu.php');

if($user->isLoggedIn()) {
    if ($user->hasPermission('edit')) {

        $siteRows = DB::getInstance()->getAssoc("SELECT * FROM sites ORDER BY site_name ASC");
        foreach($siteRows->results() as $results) {
            $site_rows[] = $results;
        }

        if(Input::exists()) {
            if(Token::check(Input::get('token'))) {
                foreach ($_POST['checkbox'] as $id) {
                    DB::getInstance()->delete('sites', array('id', '=', $id));
                }
            }
            Redirect::to('../sites/');
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
                                            <h3 class="icon chart">Remove Sites</h3>
                                        </div>
                                        <div class="widget-content">
                                            <table class="table table-bordered table-striped data-table table-sch">
                                                <thead>
                                                <tr>
                                                    <th>Check</th>
                                                    <th>Site</th>
                                                </tr>
                                                </thead>
                                                <tbody>


                                                <?php
                                                if(!empty($site_rows)) {
                                                    foreach ($site_rows as $row) {
                                                        echo '<tr class="gradeA">';
                                                        echo '<td width="1%" align="center"><input name="checkbox[]" type="checkbox" id="checkbox[]" value="'.escape($row['id']).'"></td>';
                                                        echo '<td>'.escape($row['site_name'], ENT_QUOTES).'</td>';
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
                        <button type="submit" class="btn btn-primary" tabindex="3" name="delete" id="delete">Delete Site</button>
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