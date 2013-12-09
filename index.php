<?php
# Copyright (C) 2013 Remy van Elst
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program. If not, see <http://www.gnu.org/licenses/>.
require_once("./functions.php");
require_once("./config.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php print($title . "  " . $organization); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Remy van Elst">
    <meta http-equiv="refresh" content="30">
    <link href="//netdna.bootstrapcdn.com/bootswatch/3.0.2/united/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        a {
            color: #333 !important;
        }
        .alert { 
            padding:5px 13px !important;
            border-radius: 0px !important;
            margin-bottom: 2px !important;
        }
    </style>
</head>
<body>

    <div class="row">
        <div class="col-md-12">
            <h1><?php print($title . " - " . $organization); ?></h1>
        </div>
    </div>

	<div class='row'>
        <div class="col-md-12">
       <?php
	foreach ($json_url as $url) {
          print("<div class='col-md-3'>");
            print($url['name'] . " - " . $hosts_total[$url['name']] . " Hosts - ". $service_total[$url['name']] . " Services<br />");
            if($criticals_count[$url['name']] > 0 || $host_issue_count[$url['name']] > 0) {
                print('<div class="alert alert-danger"><h2>');
                    #print('<script type="text/javascript">document.body.style.backgroundColor = "#ff0039";</script>');
                if($criticals_count[$url['name']] > 0) {
                    print(($criticals_count[$url['name']]));
                    print(" Critical Issues. ");
                }
                if ($host_issue_count[$url['name']] > 0) {
                 print($host_issue_count[$url['name']] . " Hosts Down!");
             } 
             print("<h2></div>");
         } elseif(($warnings_count[$url['name']]) > 0) {
            print('<div class="alert alert-success"><h2>');
            print(($warnings_count[$url['name']]));
            print(" Non Critical Issues</h2></div>");
        } else {
            print('<div class="alert alert-success"><h2>');
            print(" Everything Running Fine!</h2></div>");
        }
	print("</div>");
	}
        ?>
	</div>
</div>
<div class="row">
    <div class="col-md-6">
        <?php
	foreach ($json_url as $url) { host_alert_cards("Hosts Down - " . $url['name'], "danger", $host_issue_count[$url['name']], $host_issues[$url['name']]); }
        foreach ($json_url as $url) { service_alert_cards("Critical Issues - " . $url['name'], "danger", $criticals_count[$url['name']], $criticals[$url['name']]); }
        foreach ($json_url as $url) { host_alert_cards("Hosts Acknowledged Down - " . $url['name'], "info", $host_ack_issues_count[$url['name']], $host_ack_issues[$url['name']]); }
        ?>
    </div>
    <div class="col-md-6">
        <?php
        foreach ($json_url as $url) { service_alert_cards("Minor Issues - " . $url['name'], "warning", $warnings_count[$url['name']], $warnings[$url['name']]); }
        foreach ($json_url as $url) { service_alert_cards("Acknowledged Minor Issues - " . $url['name'], "info", $warnings_ack_count[$url['name']], $warnings_ack_issues[$url['name']]); }
        foreach ($json_url as $url) { service_alert_cards("Acknowledged Criticals - " . $url['name'], "info", $criticals_ack_count[$url['name']], $criticals_ack[$url['name']]); }
        ?>
    </div>
    <div class="col-md-6">
        <?php
        ?>
    </div>
</div>
<br />
<div class="row">
    <div class="container text-center">
    <span>Simple Nagios Dashboard by <a href="https://raymii.org">Remy van Elst (code)</a> and <a href="https://github.com/JobV">Job van der Voort (design)</a>.</span>
    </div>
</div>


</body>
</html>
