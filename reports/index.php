<?php
require_once '../Init.php';

$user = new User();
if($user->isLoggedIn()) {
    if(!Input::exists()) {

        $userRows = DB::getInstance()->getAssoc("SELECT * FROM users ORDER BY full_name ASC");
        foreach($userRows->results() as $results) {
            $user_rows[] = $results;
        }
        $sitesRows = DB::getInstance()->getAssoc("SELECT * FROM sites ORDER BY site_name ASC");
        foreach($sitesRows->results() as $results) {
            $sites_rows[] = $results;
        }

        $page = new Page;
        $page->setTitle('Reports');
        $page->startBody();
        echo $page->render('../includes/menu.php');
        ?>
        <script>
            $(document).ready(function() {
                $('#report').bind('change', function() {
                    var elements = $('div.hidden').children().hide(); // hide all the elements
                    var value = $(this).val();

                    if (value.length) { // if somethings' selected
                        elements.filter('.' + value).show(); // show the ones we want
                    }
                }).trigger('change');
            });
        </script>
        <div id="content">
            <div id="contentHeader"></div>
            <div class="container">
                <div class="grid-24">
                    <div class="widget">
                        <div class="widget widget-table">
                            <div class="widget-header">
                                <span class="icon-list"></span>
                                <h3 class="icon chart">Report</h3>
                            </div>
                            <div class="widget-content">
                                <form action="" method="post" class="form uniformForm">
                                    <table class="table table-bordered table-striped data-table table-sch displayed">
                                        <thead>
                                        <tr>
                                            <th>Report Type</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="field-group">
                                                    <div class="field">
                                                        <label for="site">Report Type</label>
                                                        <select name="report" id="report">
                                                            <option value="1">View all Vists to Site</option>
                                                            <option value="2">View Employee Site History</option>
                                                            <option value="3">View all Sites</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="hidden">
                                                    <div class="field-group 2" id="2">
                                                        <div class="field">
                                                            <label for="techlist">Employee</label>
                                                            <select name="techlist" id="techlist">
                                                                <?php
                                                                foreach($user_rows as $user_row) {
                                                                    echo '<option value="'.$user_row['full_name'].'">';
                                                                    echo escape($user_row['full_name']);
                                                                    echo '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="field-group 1" id="1">
                                                        <div class="field">
                                                            <label for="sitelist">Site</label>
                                                            <select name="sitelist" id="sitelist">
                                                                <?php
                                                                foreach($sites_rows as $site_row) {
                                                                    echo '<option value="'.$site_row['site_name'].'">';
                                                                    echo htmlentities($site_row['site_name'], ENT_QUOTES, 'UTF-8');
                                                                    echo '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                    <div class="login_actions">
                        <button type="submit" class="btn btn-primary" tabindex="3" name="delete" id="delete">Open Report</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <?php
        $page->endBody();
        echo $page->render('../includes/template.php');
    } else {

        $report = Input::get('report');

        if ($report == '1') {
            $site = Input::get('sitelist');

            $reportRows = DB::getInstance()->getAssoc("SELECT * FROM sched WHERE site = ?", array($site));
            foreach($reportRows->results() as $results) {
                $report_rows[] = $results;
            }
        }
        if ($report == '2') {
            $site = Input::get('techlist');

            $reportRows = DB::getInstance()->getAssoc("SELECT * FROM sched WHERE full_name = ?", array($site));
            foreach($reportRows->results() as $results) {
                $report_rows[] = $results;
            }
        }
        if ($report == '3') {
            $reportRows = DB::getInstance()->getAssoc("SELECT * FROM sites ORDER BY site_name ASC");
            foreach($reportRows->results() as $results) {
                $report_rows[] = $results;
            }
        }

        $page = new Page;
        $page->setTitle('Reports');
        $page->startBody();

        ?>

        <script type="text/javascript">
            <!--
            function printContent(id){
                str=document.getElementById(id).innerHTML
                newwin=window.open('','printwin','left=100,top=100,width=400,height=400')
                newwin.document.write('<HTML>\n<HEAD>\n')
                newwin.document.write('<TITLE>Print Page</TITLE>\n')
                newwin.document.write('<script>\n')
                newwin.document.write('function chkstate(){\n')
                newwin.document.write('if(document.readyState=="complete"){\n')
                newwin.document.write('window.close()\n')
                newwin.document.write('}\n')
                newwin.document.write('else{\n')
                newwin.document.write('setTimeout("chkstate()",2000)\n')
                newwin.document.write('}\n')
                newwin.document.write('}\n')
                newwin.document.write('function print_win(){\n')
                newwin.document.write('window.print();\n')
                newwin.document.write('chkstate();\n')
                newwin.document.write('}\n')
                newwin.document.write('<\/script>\n')
                newwin.document.write('</HEAD>\n')
                newwin.document.write('<BODY onload="print_win()">\n')
                newwin.document.write(str)
                newwin.document.write('</BODY>\n')
                newwin.document.write('</HTML>\n')
                newwin.document.close()
            }
            //-->
        </script>

        <div id="content" style="margin-left: 0px; margin-right: 0px;">
            <div id="contentHeader"></div>
            <div class="container">
                <div class="grid-24">
                    <div class="widget">
                        <div class="widget widget-table">
                            <div class="widget-header">
                                <span class="icon-list"></span>
                                <h3 class="icon chart">Report</h3>
                            </div>
                            <div class="widget-content" id="print">
                                <table class="table table-bordered table-striped data-table table-sch displayed">
                                    <?php  if ($report == '1') {?>
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Assigned To</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($report_rows as $entries) {
                                            if ($entries['type'] == 'btn-sch btn-black'){
                                                $type = "Non-Emergency";
                                            }
                                            if ($entries['type'] == 'btn-sch btn-red') {
                                                $type = "Emergency";
                                            }
                                            if ($entries['type'] == 'btn-sch btn-green') {
                                                $type = "PM";
                                            }
                                            if ($entries['type'] == 'btn-sch btn-orange') {
                                                $type = "Holiday";
                                            }
                                            if ($entries['type'] == 'btn-sch btn-purple') {
                                                $type = "PTO";
                                            }
                                            if ($entries['type'] == 'btn-sch btn-primary') {
                                                $type = "T&M";
                                            }
                                            if ($entries['type'] == 'btn-sch btn-blue') {
                                                $type = "Installed";
                                            }

                                            echo "<tr>";
                                            echo "<td>".date('m/d/Y',strtotime($entries['date']))."</td>";
                                            echo "<td>".$type."</td>";
                                            echo "<td>".$entries['notes']."</td>";
                                            echo "<td>".$entries['full_name']."</td>";
                                            echo "</tr>";
                                        } ?>
                                        </tbody>
                                    <?php } if($report == '2') { ?>
                                        <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Site</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Assigned To</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($report_rows as $entries) {
                                            if ($entries['type'] == 'btn-sch btn-black'){
                                                $type = "Non-Emergency";
                                            }
                                            if ($entries['type'] == 'btn-sch btn-red') {
                                                $type = "Emergency";
                                            }
                                            if ($entries['type'] == 'btn-sch btn-green') {
                                                $type = "PM";
                                            }
                                            if ($entries['type'] == 'btn-sch btn-orange') {
                                                $type = "Holiday";
                                            }
                                            if ($entries['type'] == 'btn-sch btn-purple') {
                                                $type = "PTO";
                                            }
                                            if ($entries['type'] == 'btn-sch btn-primary') {
                                                $type = "T&M";
                                            }
                                            if ($entries['type'] == 'btn-sch btn-blue') {
                                                $type = "Installed";
                                            }
                                            echo "<tr>";
                                            echo "<td>".date('m/d/Y',strtotime($entries['date']))."</td>";
                                            echo "<td>".$entries['site']."</td>";
                                            echo "<td>".$type."</td>";
                                            echo "<td>".$entries['notes']."</td>";
                                            echo "<td>".$entries['full_name']."</td>";
                                            echo "</tr>";
                                        } ?>
                                        </tbody>
                                    <?php } ?>
                                    <?php if($report == '3') { ?>
                                        <thead>
                                        <tr>
                                            <th>Site</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($report_rows as $entries) {
                                            echo "<tr>";
                                            echo "<td>".$entries['site_name']."</td>";
                                            echo "</tr>";
                                        } ?>
                                        </tbody>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="login_actions">
                        <button onclick="printContent('print')" class="btn btn-primary" tabindex="3">Print Report</button>
                        <button onclick="goBack()" class="btn btn-primary" tabindex="3">Go Back</button>
                    </div>
                </div>
            </div>
        </div>
    <?php
        $page->endBody();
        echo $page->render('../includes/template.php');
    }
} else {
    Redirect::to('../login/');
}
