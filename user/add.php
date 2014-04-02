<?php
require_once '../Init.php';

$user = new User();

if($user->isLoggedIn()) {
    if ($user->hasPermission('edit')) {
        if(Input::exists()) {
            if(Token::check(Input::get('token'))) {
                $validate = new Validate();
                $validation = $validate->check($_POST, array(
                    'username' => array(
                        'required' => true,
                        'min' => 2,
                        'max' => 20,
                        'unique' => 'users'
                    ),
                    'full_name' => array(
                        'required' => true,
                        'min' => 2,
                        'max' => 50
                    ),
                    'work_group' => array(
                        'required' => true,
                        'min' => 2,
                        'max' => 50
                    ),
                    'work_number' => array(
                        'required' => true,
                        'min' => 10,
                        'max' => 20
                    ),
                    'email' => array(
                        'required' => true,
                        'min' => 7
                    ),
                    'password' => array(
                        'required' => true,
                        'min' => 6
                    ),
                    'password_again' => array(
                        'required' => true,
                        'matches' => 'password'
                    )
                ));

                if($validation->passed()) {
                    $salt = Hash::salt(32);

                    try {
                        $user->createUser(array(
                            'username' => Input::get('username'),
                            'password' => Hash::make(Input::get('password'), $salt),
                            'salt' => $salt,
                            'full_name' => Input::get('full_name'),
                            'work_group' => Input::get('work_group'),
                            'work_number' => Input::get('work_number'),
                            'email' => Input::get('email'),
                            'group' => 1
                        ));

                        Redirect::to('../user/');

                    } catch(Exception $e) {
                        die($e->getMessage());
                    }
                } else {
                    foreach($validation->errors() as $errors) {
                        $error = ucfirst($errors);
                        echo '<script type="text/javascript"> alert(\''.$error.'\'); </script>';
                    }
                }
            }
        }

        $page = new Page;
        $page->setTitle('Add User');
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
                        <div class="widget-content">
                            <div class="field-group">
                                <div class="field">
                                    <label for="email">Username</label>
                                    <input type="text" name="username" value="<?php echo escape(Input::get('username')); ?>" id="username" tabindex="1" size="63" placeholder="Username" />
                                </div>
                            </div>
                            <div class="field-group">
                                <div class="field">
                                    <label for="full_name">Full Name</label>
                                    <input type="text" name="full_name" value="<?php echo escape(Input::get('full_name')); ?>" id="full_name" tabindex="1" size="63" placeholder="Full Name" />
                                </div>
                            </div>
                            <div class="field-group">
                                <div class="field">
                                    <label for="work_group">Work Group</label>
                                    <input type="text" name="work_group" value="<?php echo escape(Input::get('work_group')); ?>" id="work_group" tabindex="1" size="63" placeholder="work_group" />
                                </div>
                            </div>
                            <div class="field-group">
                                <div class="field">
                                    <label for="work_number">Work Number</label>
                                    <input type="text" name="work_number" value="<?php echo escape(Input::get('work_number')); ?>" id="work_number" tabindex="1" size="63" placeholder="Work Number" />
                                </div>
                            </div>
                            <div class="field-group">
                                <div class="field">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" value="<?php echo escape(Input::get('email')); ?>" id="email" tabindex="1" size="63" placeholder="Email" />
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

                            <div class="login_actions">
                                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
                                <button type="submit" name="register" class="btn btn-primary" tabindex="3">Add User</button>
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
}
