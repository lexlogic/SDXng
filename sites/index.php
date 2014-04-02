<?php
require_once '../Init.php';

$user = new User();
if($user->isLoggedIn()) {
    $sitesRows = DB::getInstance()->getAssoc("SELECT * FROM sites");
    foreach($sitesRows->results() as $results) {
        $sites_rows[] = $results;
    }

    $page = new Page;
    $page->setTitle('Sites');
    $page->startBody();
    echo $page->render('../includes/menu.php');
    ?>

    <div id="content">

        <div id="contentHeader"></div>

        <div class="container">

            <?php
            if ($user->hasPermission('edit')) {
                echo '<div class="grid-24">';
                echo '<a href="add.php"><button class="btn-lgn btn-green">Add Site</button></a>';
                echo '<a href="remove.php"><button class="btn-lgn btn-red">Remove Site</button></a>';
                echo '</div>';
            }
            ?>
            <div class="grid-24">
                <div class="widget">
                    <div class="widget widget-table">
                        <div class="widget-header">
                            <span class="icon-list"></span>
                            <h3 class="icon chart">Sites</h3>
                        </div>
                        <div class="widget-content">
                            <table class="table table-bordered table-striped data-table table-sch displayed">
                                <thead>
                                <tr>
                                    <th>Company</th>
                                    <th>Address</th>
                                    <th>Contact Names</th>
                                    <th>Contact Numbers</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <form action="" method="post">
                                    <?php
                                    if(!empty($sites_rows)) {
                                        foreach($sites_rows as $sites_row) {
                                            echo '<tr class="gradeA">';
                                            echo '<td>'.escape($sites_row['site_name']).'</td>';
                                            echo '<td>'.escape($sites_row['site_address']);
                                            echo '<br>'.escape($sites_row['site_city']);
                                            echo ','.escape($sites_row['site_state']);
                                            echo ' '.escape($sites_row['site_zip']);

                                            echo '<td>';
                                            echo escape($sites_row['primary_contact_name']);
                                            echo '</td>';
                                            echo '<td>';
                                            echo escape($sites_row['primary_contact_number']);
                                            echo '</td>';
                                            if ($user->hasPermission('edit')) {
                                                echo '<td><a href="edit.php?id='.escape($sites_row['id']).'" class="icon-pen"></a>';
                                                echo '<a href="view.php?id='.escape($sites_row['id']).'" class="icon-document-alt-stroke"></a>';
                                                echo '</td>';
                                            }
                                            else
                                                echo '<td><a href="view.php?id='.escape($sites_row['id']).'" class="icon-document-alt-stroke"></a></td>';
                                            echo '</tr>';
                                        }
                                    }
                                    ?>
                                </form>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
