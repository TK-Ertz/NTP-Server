<?php

include_once '/home/admin/lib/php/session.php';
include_once '/home/admin/lib/php/beroGui.class.php';


function get_ntpd_version () {
	
	if (file_exists('/apps/NTP-Server/VERSION')) {
		foreach(file('/apps/NTP-Server/VERSION/') as $line) {
			if (preg_match('/VERSION=([0-9]*)/', $line, $res)) {
				return($res[1]);
			}
		}
	}
	
	return('unknown');
}

function get_ntpd_enabled() {

	$filename = '/apps/NTP-Server/etc/ntpd';

	if ($fp = @fopen($filename, 'r')) {
		$cont = fread($fp, filesize($filename));
		return (strstr($cont, 'NTPD_ENABLED=yes') ? true : false);
	}

	return false;
}

function ntpd_services($cmd) {

	if (in_array($cmd, array('start','stop','restart'))) {
		exec('/apps/NTP-Server/init/S01ntpd '. $cmd .' >/dev/null');
		usleep(250000);
	}
}

function ntpd_save() {

	$filename = '/apps/NTP-Server/etc/ntpd';

	if ($fp = @fopen($filename, 'w')) {
		$line = 'NTPD_ENABLED='. ($_GET['enabled'] == '1' ? 'yes' : 'no') ."\n";
		fwrite($fp, $line);
		chown($filename, 'admin');
		chgrp($filename, 'admin');
	}

	ntpd_services('restart');
}


if (!empty($_GET['execute']) && $_GET['execute'] == 'services') ntpd_services($_GET['services']);
if (!empty($_GET['execute']) && $_GET['execute'] == 'save'    ) ntpd_save();


$bg = new beroGUIv2('NTP-Server');


echo $bg->get_MainHeader(NULL, NULL);


echo '<br />'. "\n";

echo '<h2>NTP-Server Settings</h2>' ."\n";
echo '<form class="extensions_form" name="ntpd_settings" action="index.php" method="GET">' ."\n";
echo "\t". '<div style="float: right; width: 125px;">' ."\n";
echo "\t\t". '<input type="hidden" name="execute" value="save" />' ."\n";
echo "\t\t". '<input type="submit" value="Apply" />' ."\n";
echo "\t". '</div>' ."\n";
echo "\t". '<div style="margin-left: 5px; float: left; width: 200px; font-weight: bold;">' ."\n";
echo "\t\t". 'Enable NTP-Server: '. "\n";
echo "\t". '</div>' ."\n";
echo "\t". '<div><input type="checkbox" name="enabled" value="1" '. (get_ntpd_enabled() ? ' checked' : '') .'/></div>' ."\n";
echo '</form>' ."\n";

echo '<br />' ."\n";

echo '<h2>NTP-Server State</h2>' ."\n";
echo "\t". '<form class="extensions_form" name="ntpd_services" action="index.php" method="GET">' ."\n";
echo "\t\t". '<div style="float: right; width: 290px;">' ."\n";
echo "\t\t\t". '<input type="hidden" name="execute" value="services" />' ."\n";
echo "\t\t\t". '<input type="submit" name="services" value="start" />' ."\n";
echo "\t\t\t". '<input type="submit" name="services" value="stop" />' ."\n";
echo "\t\t\t". '<input type="submit" name="services" value="restart" />' ."\n";
echo "\t\t". '</div>' ."\n";
echo "\t". '<div style="margin-left: 5px; font-weight: bold;">NTP-Server are currently ';
if (get_ntpd_enabled() == true) {
	if ($pid = exec('/bin/pidof -s ntpd')) {
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
echo "\t". 'Version '. get_ntpd_version() ."\n";
echo '</div>' ."\n";


# own Footer with Link to own Website and GitHub
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
