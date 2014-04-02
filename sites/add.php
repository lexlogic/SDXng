<?php
require_once '../Init.php';

$user = new User();
$page = new Page;
$page->setTitle('Add Site');
$page->startBody();
echo $page->render('../includes/menu.php');

if($user->isLoggedIn()) {
    if ($user->hasPermission('edit')) {
        if(Input::exists()) {
            if(Token::check(Input::get('token'))) {
                $validate = new Validate();
                $validation = $validate->check($_POST, array(
                    'site_name' => array(
                        'required' => true
                    ),
                    'site_address' => array(
                        'required' => true
                    ),
                    'site_city' => array(
                        'required' => true
                    ),
                    'site_state' => array(
                        'required' => true
                    ),
                    'site_zip' => array(
                        'required' => true
                    )
                ));

                if($validation->passed()) {

                    if(isset($_POST["isConfirmed"]))
                    {
                        $isConfirmed = 1;
                    } else {
                        $isConfirmed = 0;
                    }

                    try {
                        $user->createSite(array(
                            'site_name' => Input::get('site_name'),
                            'site_address' => Input::get('site_address'),
                            'site_city' => Input::get('site_city'),
                            'site_state' => Input::get('site_state'),
                            'site_zip' => Input::get('site_zip'),
                            'primary_contact_name' => Input::get('primary_contact_name'),
                            'primary_contact_number' => Input::get('primary_contact_number'),
                            'secondary_contact_name' => Input::get('secondary_contact_name'),
                            'secondary_contact_number' => Input::get('secondary_contact_number'),
                            'site_notes' => Input::get('site_notes'),
                            'callAhead' => $isConfirmed

                        ));

                        Redirect::to('../sites/');

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
                                            <label for="email">Site Name</label>
                                            <input type="text" name="site_name" size="63" value="<?php echo escape(Input::get('site_name')); ?>" id="site_name" tabindex="1" placeholder="Site Name" />
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="full_name">Address</label>
                                            <input type="text" name="site_address" size="63" value="<?php echo escape(Input::get('site_address')); ?>" id="site_address" tabindex="1" placeholder="Site Address" />
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="city">City</label>
                                            <input type="text" name="site_city" size="63" value="<?php echo escape(Input::get('site_city')); ?>" id="site_city" tabindex="1" placeholder="City" />
                                        </div>
                                        <div class="field">
                                            <label for="zip">State</label>
                                            <input type="text" name="site_state" size="63" value="<?php echo escape(Input::get('site_state')); ?>" id="site_state" placeholder="State"  rows="1" cols="10" tabindex="1"/></textarea>
                                        </div>
                                        <div class="field">
                                            <label for="zip">Zip</label>
                                            <input type="text" name="site_zip" size="63" value="<?php echo escape(Input::get('site_zip')); ?>" id="site_zip" placeholder="Zip"  tabindex="1"/></textarea>
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="primary_contact_name">Primary Contact Name</label>
                                            <input type="text" name="primary_contact_name" size="63" value="<?php echo escape(Input::get('primary_contact_name')); ?>" id="primary_contact_name" tabindex="1" placeholder="Primary Contact Name" />
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="primary_contact_number">Primary Contact Number</label>
                                            <input type="text" name="primary_contact_number" size="63" value="<?php echo escape(Input::get('primary_contact_number')); ?>" id="primary_contact_number" tabindex="1" placeholder="Primary Contact Number" />
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="secondary_contact_name">Secondary Contact Name</label>
                                            <input type="text" name="secondary_contact_name" size="63" value="<?php echo escape(Input::get('secondary_contact_name')); ?>" id="secondary_contact_name" tabindex="1" placeholder="Secondary Contact Name" />
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="secondary_contact_number">Secondary Contact Number</label>
                                            <input type="text" name="secondary_contact_number" size="63" value="<?php echo escape(Input::get('secondary_contact_number')); ?>" id="secondary_contact_number" tabindex="1" placeholder="Secondary Contact Number" />
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="site_notes">Notes</label>
                                            <textarea name="site_notes" value="<?php echo escape(Input::get('site_notes')); ?>" id="site_notes" placeholder="Notes"  rows="10" cols="63" tabindex="1"/></textarea>
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="isConfirmed">Requires Confirmation
                                                <input type="checkbox" name="isConfirmed" value="confirmed" />
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="widget-content">
                                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
                                    <button type="submit" class="btn btn-primary" tabindex="3">Add Site</button>
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