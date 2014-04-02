<?php
require_once '../Init.php';

$user = new User();
if($user->isLoggedIn()) {
    $userRows = DB::getInstance()->getAssoc("SELECT * FROM users ORDER BY full_name ASC");
    foreach($userRows->results() as $results) {
        $user_rows[] = $results;
    }

    $page = new Page;
    $page->setTitle('Employees');
    $page->startBody();
    echo $page->render('../includes/menu.php');
    ?>

<div id="content">
    <div id="contentHeader">
    </div>
    <div class="container">
        <?php
        if ($user->hasPermission('edit')) {
            echo '<div class="grid-24">';
            echo '<a href="add.php"><button class="btn-lgn btn-green">Add User</button></a>';
            echo '<a href="remove.php"><button class="btn-lgn btn-red">Remove User</button></a>';
            echo '</div>';
        }
        ?>
        <div class="grid-24">
            <div class="widget">
                <div class="widget widget-table">
                    <div class="widget-header">
                        <span class="icon-list"></span>
                        <h3 class="icon chart">Employees</h3>
                    </div>
                    <div class="widget-content">
                        <table class="table table-bordered table-striped data-table table-sch displayed">
                            <thead>
                            <tr>
                                <th>Employees</th>
                                <th>Group(s)</th>
                                <th>Primary Contact</th>
                                <th>Alternate Contact</th>
                                <th>PTO Remaining</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($user_rows as $row): ?>
                                <tr class="gradeA">
                                    <td><?php echo escape($row['full_name']); ?></td>
                                    <td><?php echo escape($row['work_group']); ?></td>
                                    <td><?php echo escape($row['work_number']); ?></td>
                                    <td><?php echo escape($row['alt_number']); ?></td>
                                    <td><?php echo escape($row['pto']); ?></td>
                                    <?php
                                    $fullname = escape($row['full_name']);
                                    if ($user->hasPermission('edit')) {
                                        echo '<td><a href="edit.php?id='.escape($row['id']).'" class="icon-pen"></a>';
                                        echo '<a href="view.php?id='.escape($row['id']).'" class="icon-document-alt-stroke"></a></td>';
                                    }
                                    else
                                        echo '<td><a href="view.php?id='.escape($row['id']).'" class="icon-document-alt-stroke"></a></td>';
                                    ?>
                                </tr>
                            <?php endforeach; ?>
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