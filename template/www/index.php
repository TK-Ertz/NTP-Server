<?php

include_once '/home/admin/lib/php/session.php';
include_once '/home/admin/lib/php/beroGui.class.php';
include_once 'class.ntp.php';

$bg = new beroGUIv2('NTP-Server');

$ntp = new NTP();


# execute
#
if (!empty($_REQUEST['execute']) && $_REQUEST['execute'] == 'services') {
	if ($_REQUEST['services'] == 'Start') {
		$ntp->start();
	} elseif ($_REQUEST['services'] == 'Stop') {
		$ntp->stop();
	} elseif ($_REQUEST['services'] == 'Restart') {
		$ntp->restart();
	}
}

if (!empty($_REQUEST['execute']) && $_REQUEST['execute'] == 'save') {
	if ($_REQUEST['enabled'] == '1') {
		$ntp->set_enabled();
	} else {
		$ntp->set_disabled();
	}
}


# display Header
#
echo $bg->get_MainHeader(NULL, NULL);


# display Body
#
echo '<br />'. "\n";

echo '<h2>NTP-Server Settings</h2>' ."\n";
echo '<form class="extensions_form" name="ntpd_settings" action="index.php" method="POST">' ."\n";
echo "\t". '<div style="float: right; width: 125px;">' ."\n";
echo "\t\t". '<input type="hidden" name="execute" value="save" />' ."\n";
echo "\t\t". '<input type="submit" value="Apply" />' ."\n";
echo "\t". '</div>' ."\n";
echo "\t". '<div style="margin-left: 5px; float: left; width: 200px; font-weight: bold;">' ."\n";
echo "\t\t". 'Enable NTP-Server: '. "\n";
echo "\t". '</div>' ."\n";
echo "\t". '<div><input type="checkbox" name="enabled" value="1" '. ($ntp->is_enabled() ? ' checked' : '') .'/></div>' ."\n";
echo '</form>' ."\n";

echo '<br />' ."\n";

echo '<h2>NTP-Server State</h2>' ."\n";
echo '<form class="extensions_form" name="ntpd_services" action="index.php" method="POST">' ."\n";
echo "\t". '<div style="float: right; width: 290px;">' ."\n";
echo "\t\t". '<input type="hidden" name="execute" value="services" />' ."\n";
echo "\t\t". '<input type="submit" name="services" value="Start" />' ."\n";
echo "\t\t". '<input type="submit" name="services" value="Stop" />' ."\n";
echo "\t\t". '<input type="submit" name="services" value="Restart" />' ."\n";
echo "\t". '</div>' ."\n";
echo "\t". '<div style="margin-left: 5px; font-weight: bold;">NTP-Server are currently ';
if ($ntp->is_enabled() == true) {
	if ($ntp->is_running()) {
		echo '<span style="color:green">running</span>';
	} else {
		echo '<span style="color:red">stopped</span>';
	}
} else {
	echo '<span style="color:red">disabled</span>';
}
echo '</div>' ."\n";
echo '</form>' ."\n";

echo '<br />' ."\n";
echo '<br />' ."\n";

echo '<div style="background-color: transparent; color: grey; float: right; width: 200px; text-align: right; font-size: 10px; margin-right: 40px;">' ."\n";
echo "\t". 'Version '. $ntp->get_version() ."\n";
echo '</div>' ."\n";


# display own Footer with Link to own Website and GitHub
#
echo "\n\n". '<!-- BEGIN FUNCTION _HTML_FOOTER //-->' ."\n\n";
echo "\t\t\t". '<div id="footer" class="clear">' ."\n";
echo "\t\t\t\t". '<div class="part1">' ."\n";
echo "\t\t\t\t\t". 'Copyright &copy; 2014 <a href="http://www.tk-ertz.de" target="_blank">TK- und IT-Service Ertz</a>, Germany' ."\n";
echo "\t\t\t\t". '</div>' ."\n";
echo "\t\t\t\t". '<div class="part2">' ."\n";
echo "\t\t\t\t\t". '<div class="right">' ."\n";
echo "\t\t\t\t\t\t". '<a href="http://www.github.com/TK-Ertz/NTP-Server" target="_blank">GitHub</a>' ."\n";
echo "\t\t\t\t\t". '</div>' ."\n";
echo "\t\t\t\t". '</div>' ."\n";

echo "\t\t\t". '</div>' ."\n";
echo "\t\t". '</div>' ."\n";
echo "\t". '</body>' ."\n";
echo '</html>' ."\n";

?>
