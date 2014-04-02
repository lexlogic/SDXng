<?php
require_once '../Init.php';

$user = new User();
if (isset($_GET["id"])) {
        $id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['id']);
}

if (!isset($id)) {
    Redirect::to('../user/');
}

if($user->isLoggedIn() || $user->hasPermission('edit') || $id == $user->data()->id) {

$userRows = DB::getInstance()->getAssoc("SELECT * FROM users WHERE id = ?", array($id));
foreach($userRows->results() as $results) {
    $user_rows[] = $results;
}
    if(Input::exists()) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'full_name' => array(
                'required' => true
            )
        ));
        if($validation->passed()) {
            if(!empty($_POST['password'])) {
                $passwordValidate = $validate->check($_POST, array(
                    'password_again' => array(
                        'required' => true,
                        'matches' => 'password'
                    )
                ));
                if($passwordValidate->passed()) {
                    $salt = Hash::salt(32);
                    $update = DB::getInstance()->update('users', $id, array(
                        'full_name' => Input::get('full_name'),
                        'work_number' => Input::get('work_number'),
                        'alt_number' => Input::get('alt_number'),
                        'msg_address' => Input::get('msg_address'),
                        'work_group' => Input::get('work_group'),
                        '`group`' => Input::get('AccessLevel'),
                        'start_time' => Input::get('start_time'),
                        'stop_time' => Input::get('stop_time'),
                        'email' => Input::get('email'),
                        'pto' => Input::get('pto'),
                        'password' => Hash::make(Input::get('password'), $salt),
                        'salt' => $salt
                    ));
                    Redirect::to('../user/');

                }
            } else {
                $update = DB::getInstance()->update('users', $id, array(
                    'full_name' => Input::get('full_name'),
                    'work_number' => Input::get('work_number'),
                    'alt_number' => Input::get('alt_number'),
                    'msg_address' => Input::get('msg_address'),
                    'work_group' => Input::get('work_group'),
                    '`group`' => Input::get('AccessLevel'),
                    'start_time' => Input::get('start_time'),
                    'stop_time' => Input::get('stop_time'),
                    'email' => Input::get('email'),
                    'pto' => Input::get('pto')
                ));
                Redirect::to('../user/');
            }

        } else {
            foreach($validation->errors() as $error) {
                $error = ucfirst($error);
                echo '<script type="text/javascript"> alert(\''.$error.'\'); </script>';
            }
        }
    }

$page = new Page;
$page->setTitle('Edit Employee');
$page->startBody();
echo $page->render('../includes/menu.php');

?>

<div id="content">
    <div id="contentHeader"></div>
    <div class="container">
        <div class="grid-24">
            <div class="row">
                <div class="widget">
                    <form action="" method="post" accept-charset="utf-8" class="form uniformForm">
                        <?php foreach($user_rows as $row): ?>
                            <div class="widget-header">
                                <span class="icon-article"></span>
                                <h3>Editing <?php echo escape($row['full_name']); ?></h3>
                            </div>
                            <div class="widget-content">
                                <div class="field-group">
                                    <div class="field">
                                        <label for="full_name">Name</label>
                                        <input type="text" name="full_name" size="63" value="<?php echo escape($row['full_name']); ?>" id="full_name" tabindex="1" placeholder="Name"/>
                                    </div>
                                    <div class="field">
                                        <label for="tech_id">Tech ID</label>
                                        <input type="text" name="tech_id" size="63" value="<?php echo escape($row['id']); ?>" id="tech_id" tabindex="1" placeholder="tech_id" readonly/>
                                    </div>
                                </div>
                                <div class="field-group">
                                    <div class="field">
                                        <label for="work_number">Primary Number</label>
                                        <input type="text" name="work_number" size="63" value="<?php echo escape($row['work_number']); ?>" id="work_number" tabindex="1" placeholder="Work Number" />
                                    </div>
                                    <div class="field">
                                        <label for="alt_number">Alternate Number</label>
                                        <input type="text" name="alt_number" size="63" value="<?php echo escape($row['alt_number']); ?>" id="alt_number" tabindex="1" placeholder="Alternate Number" />
                                    </div>
                                    <div class="field">
                                        <label for="msg_address">Msg Address</label>
                                        <input type="text" name="msg_address" size="63" value="<?php echo str_replace("-", "", escape($row['work_number']))."@txt.att.net"; ?>" id="msg_address" tabindex="1" placeholder="msg_address" />
                                    </div>
                                </div>
                                <div class="field-group">
                                    <div class="field">
                                        <label for="work_group">Work Group</label>
                                            <input type="text" name="work_group" size="63" value="<?php echo escape($row['work_group']); ?>" id="work_group" tabindex="1" placeholder="work_group" />
                                    </div>
                                </div>
                                <?php if($user->hasPermission('edit')) { ?>
                                <div class="field-group">
                                    <div class="field">
                                        <label for="work_group">Access Level</label>
                                        <select name="AccessLevel" id="AccessLevel" tabindex="1">
                                            <?php
                                            if($row['group'] == 1) {
                                                $current = 'View only';
                                            } else {
                                                $current = 'View/Edit';
                                            }
                                            echo '<option value="'.escape($row['group']).'">';
                                            echo 'Current Level: '.$current;
                                            echo '</option>';
                                            echo '<option value="1">';
                                            echo "View Only";
                                            echo '</option>';
                                            echo '<option value="3">';
                                            echo "View/Edit";
                                            echo '</option>';
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="field-group">
                                    <div class="field">
                                        <label for="start_time">Day Starts</label>
                                            <input type="text" name="start_time" size="63" value="<?php echo escape($row['start_time']); ?>" id="start_time" tabindex="1" placeholder="Day Starts" />
                                    </div>
                                    <div class="field">
                                        <label for="stop_time">Day Ends</label>
                                            <input type="text" name="stop_time" size="63" value="<?php echo escape($row['stop_time']); ?>" id="stop_time" tabindex="1" placeholder="Day Stops" />
                                    </div>
                                </div>
                                <div class="field-group">
                                    <div class="field">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" size="63" value="<?php echo escape($row['email']); ?>" id="email" tabindex="1" placeholder="Email" />
                                    </div>
                                </div>
                                <div class="field-group">
                                    <div class="field">
                                        <label for="pto">Total PTO Left</label>
                                            <input type="text" name="pto" size="63" value="<?php echo escape($row['pto']); ?>" id="pto" tabindex="1" placeholder="PTO Remaining" />
                                    </div>
                                </div>
                                <div class="field-group">
                                    <div class="field">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" value="" id="password" tabindex="1" size="63" placeholder="Password" />
                                    </div>
                                </div>
                                <div class="field-group">
                                    <div class="field">
                                        <label for="password_again">Password Again</label>
                                        <input type="password" name="password_again" value="" id="password_again" tabindex="1" size="63" placeholder="Password Again" />
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="widget-content">
                            <div class="field">
                                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
                                <button class="btn btn-primary" tabindex="3">Save</button>
                            </div>
                            <div style="clear:both;"></div>
                        </div>
                    </form>
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
