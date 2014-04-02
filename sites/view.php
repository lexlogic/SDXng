<?php
require_once '../Init.php';

$user = new User();
if($user->isLoggedIn() && $user->hasPermission('edit')) {

    if (isset($_GET["id"])) {
        $id = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['id']);
    }

    if (!isset($id)) {
        Redirect::to('../sites/');
    }

    $siteRows = DB::getInstance()->getAssoc("SELECT * FROM sites WHERE id = ?", array($id));
    foreach($siteRows->results() as $results) {
        $site_rows[] = $results;
    }
    $page = new Page;
    $page->setTitle('Viewing '.$site_rows[0]['site_name']);
    $page->startBody();
    echo $page->render('../includes/menu.php');

    ?>


    <div id="content">
        <div id="contentHeader"></div>
        <div class="container">
            <div class="grid-24">
                <div class="row">
                    <div class="widget">
                        <div class="form uniformForm">
                            <?php foreach($site_rows as $row): ?>
                                <div class="widget-header">
                                    <span class="icon-article"></span>
                                    <h3>Viewing <?php echo escape($site_rows[0]['site_name']); ?></h3>
                                </div>
                                <div class="widget-content">
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="site_name">Site Name</label>
                                            <input type="text" name="site_name" size="63" value="<?php echo escape($row['site_name']); ?>" id="site_name" tabindex="1" placeholder="Site Name" readonly/>
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="contract_number">Contract Number</label>
                                            <input type="text" name="contract_number" size="63" value="<?php echo escape($row['contract_number']); ?>" id="contract_number" tabindex="1" placeholder="Contract Number" readonly/>
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="site_address">Address</label>
                                            <input type="text" name="site_address" size="63" value="<?php echo escape($row['site_address']); ?>" id="site_address" tabindex="1" placeholder="Site Address" readonly/>
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="site_city">City</label>
                                            <input type="text" name="site_city" value="<?php echo escape($row['site_city']); ?>" id="site_city" tabindex="1" placeholder="City" readonly/>
                                        </div>
                                        <div class="field">
                                            <label for="site_state">State</label>
                                            <input type="text" name="site_state" id="site_state" value="<?php echo escape($row['site_state']); ?>" tabindex="1" placeholder="State"  size="3" readonly/>
                                        </div>
                                        <div class="field">
                                            <label for="site_zip">Zip</label>
                                            <input type="text" name="site_zip" id="site_zip" value="<?php echo escape($row['site_zip']); ?>" tabindex="1" placeholder="Zip"  size="6" readonly/>
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="primary_contact_name">Primary Contact Name</label>
                                            <input type="text" name="primary_contact_name" size="63" value="<?php echo escape($row['primary_contact_name']); ?>" id="primary_contact_name" tabindex="1" placeholder="Primary Contact Name" readonly/>
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="primary_contact_number">Primary Contact Number</label>
                                            <input type="text" name="primary_contact_number" size="63" value="<?php echo escape($row['primary_contact_number']); ?>" id="primary_contact_number" tabindex="1" placeholder="Primary Contact Number" readonly/>
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="secondary_contact_name">Secondary Contact Name</label>
                                            <input type="text" name="secondary_contact_name" size="63" value="<?php echo escape($row['secondary_contact_name']); ?>" id="secondary_contact_name" tabindex="1" placeholder="Secondary Contact Name" readonly/>
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="secondary_contact_number">Secondary Contact Number</label>
                                            <input type="text" name="secondary_contact_number" size="63" value="<?php echo escape($row['secondary_contact_number']); ?>" id="secondary_contact_number" tabindex="1" placeholder="Secondary Contact Number" readonly/>
                                        </div>
                                    </div>
                                    <div class="field-group">
                                        <div class="field">
                                            <label for="site_notes">Notes</label>
                                            <textarea name="site_notes" id="site_notes" placeholder="Notes"  rows="10" cols="63" tabindex="1" readonly/><?php print escape($row['site_notes']); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="widget-content">
                                <div class="field">
                                    <button onclick="goBack()" class="btn btn-primary" tabindex="3">Go Back</button>
                                </div>
                                <div style="clear:both;"></div>
                            </div>
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
