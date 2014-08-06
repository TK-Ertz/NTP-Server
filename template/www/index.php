<?php

# Define functions below this line.

function gui_menu() {

	$ret  = '';
	$ret .= "\t\t\t\t". '<!-- MENU START -->' ."\n";
	$ret .= "\t\t\t\t\t". '<div id="myslidemenu" class="jqueryslidemenu">' ."\n";
	$ret .= "\t\t\t\t\t\t". '<ul id="navigation">' ."\n";
	$ret .= "\t\t\t\t\t\t\t". '<li style="white-space: nowrap;">' ."\n";
	$ret .= "\t\t\t\t\t\t\t\t". '<a href="#" id="management">Management +</a>' ."\n";
	$ret .= "\t\t\t\t\t\t\t\t". '<ul>' ."\n";
	$ret .= "\t\t\t\t\t\t\t\t\t". '<li style="white-space: nowrap;">' ."\n";
	$ret .= "\t\t\t\t\t\t\t\t\t\t". '<a href="/userapp/" id="app_management">App Management</a>' ."\n";
	$ret .= "\t\t\t\t\t\t\t\t\t". '</li>' ."\n";
	$ret .= "\t\t\t\t\t\t\t\t\t". '<li style="white-space: nowrap;">' ."\n";
	$ret .= "\t\t\t\t\t\t\t\t\t\t". '<a href="/app/berogui/index.php?m=market" id="app_market">App Market</a>' ."\n";
	$ret .= "\t\t\t\t\t\t\t\t\t". '</li>' ."\n";
	$ret .= "\t\t\t\t\t\t\t\t\t". '<li style="white-space: nowrap;">' ."\n";
	$ret .= "\t\t\t\t\t\t\t\t\t\t". '<a href="/app/berogui/" id="berogui">beroGui</a>' ."\n";
	$ret .= "\t\t\t\t\t\t\t\t\t". '</li>' ."\n";
	$ret .= "\t\t\t\t\t\t\t\t\t". '<li style="white-space: nowrap;">' ."\n";
	$ret .= "\t\t\t\t\t\t\t\t\t\t". '<a href="/app/berogui/includes/logout.php" id="berogui">Logout</a>' ."\n";
	$ret .= "\t\t\t\t\t\t\t\t\t". '</li>' ."\n";
	$ret .= "\t\t\t\t\t\t\t\t". '</ul>' ."\n";
	$ret .= "\t\t\t\t\t\t\t". '</li>' ."\n";
	$ret .= "\t\t\t\t\t\t". '</ul>' ."\n";
	$ret .= "\t\t\t\t\t". '</div>' ."\n";
	$ret .= "\t\t\t\t". '<!-- MENU END -->' ."\n";

	return $ret;
}

function gui_header($title) {

	$ret  = '';
	$ret .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 Transitional//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11-transitional.dtd">' ."\n";
	$ret .= '<html>' ."\n";
	$ret .= "\t". '<head>' ."\n";
	$ret .= "\t\t". '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' ."\n";
	$ret .= "\t\t". '<title>' . $title . '</title>' ."\n";
	$ret .= "\t\t". '<link type="image/x-icon" href="/userapp/shared/img/favicon.ico" rel="icon" />' ."\n";
	$ret .= "\t\t". '<link type="text/css" href="/userapp/shared/css/screen.css" rel="Stylesheet" />' ."\n";
	$ret .= "\t\t". '<link type="text/css" href="/userapp/shared/css/template_css.css" rel="Stylesheet" />' ."\n";
	$ret .= "\t\t". '<link type="text/css" href="/userapp/shared/css/jquery-ui-1.8.21.custom.css" rel="Stylesheet" />' ."\n";
	$ret .= "\t\t". '<link type="text/css" href="/userapp/shared/css/jqueryslidemenu.css" rel="Stylesheet" />' ."\n";
	$ret .= "\t\t". '<script type="text/javascript" language="javascript" src="/userapp/shared/js/jquery-1.7.2.min.js"></script>' ."\n";
	$ret .= "\t\t". '<script type="text/javascript" language="javascript" src="/userapp/shared/js/jquery-ui-1.8.21.custom.min.js"></script>' ."\n";
	$ret .= "\t\t". '<script type="text/javascript" language="javascript" src="/userapp/shared/js/jqueryslidemenu.js"></script>' ."\n";
	$ret .= "\t". '</head>' ."\n";
	$ret .= "\t". '<body>' ."\n";
	$ret .= "\t\t". '<div class="container" id="page">' ."\n";
	$ret .= "\t\t\t". '<div id="header">' ."\n";
	$ret .= "\t\t\t\t". '<div id="logo" style="margin-bottom: 30px;">' ."\n";
	$ret .= "\t\t\t\t\t". '<a href="http://www.beronet.com/" target="_blank">' ."\n";
	$ret .= "\t\t\t\t\t\t". '<img src="/userapp/shared/img/beroNet.jpg" alt="beroNet" class="png" />' ."\n";
	$ret .= "\t\t\t\t\t". '</a>' ."\n";
	$ret .= "\t\t\t\t". '</div>' ."\n";
	$ret .= gui_menu();
	$ret .= "\t\t\t". '</div>' ."\n";
	$ret .= "\t\t\t". '<div id="pageName" class="clear">' ."\n";
	$ret .= "\t\t\t\t". '<div class="part1">' ."\n";
	$ret .= "\t\t\t\t\t". '<h1>'. $title .'</h1>' ."\n";
	$ret .= "\t\t\t\t". '</div>' ."\n";
	$ret .= "\t\t\t". '</div>' ."\n";
	$ret .= "\n";
	$ret .= '<!-- HEADER END -->' ."\n\n";

	return $ret;
}

function gui_footer() {

	$ret  = '';
	$ret .= "\n";
	$ret .= '<!--FOOTER START -->' ."\n";
	$ret .= "\t\t\t". '<div id="footer" class="clear">' ."\n";
	$ret .= "\t\t\t\t". '<div class="part1">' ."\n";
	$ret .= "\t\t\t\t\t". 'Copyright &copy; 2014 <a href="http://www.tk-ertz.de" target="_blank">TK- und IT-Service Ertz</a>, Germany' ."\n";
	$ret .= "\t\t\t\t". '</div>' ."\n";
	$ret .= "\t\t\t\t". '<div class="part2">' ."\n";
	$ret .= "\t\t\t\t\t". '<div class="right">' ."\n";
	$ret .= "\t\t\t\t\t\t". '<a href="http://www.github.com/TK-Ertz/NTP-Server" target="_blank">GitHub</a>' ."\n";
	$ret .= "\t\t\t\t\t". '</div>' ."\n";
	$ret .= "\t\t\t\t". '</div>' ."\n";

	$ret .= "\t\t\t". '</div>' ."\n";
	$ret .= "\t\t". '</div>' ."\n";
	$ret .= "\t". '</body>' ."\n";
	$ret .= '</html>' ."\n";

	return $ret;
}

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

# Define functions above this line.


# Name of your app:
$app_name = 'NTP-Server';

# Basepath of your app:
$base_path = '/apps/' . $app_name;

# BEGIN Session management #

include_once '/home/admin/lib/php/session.php';

#  END session management  #


if (!empty($_GET['execute']) && $_GET['execute'] == 'services') ntpd_services($_GET['services']);
if (!empty($_GET['execute']) && $_GET['execute'] == 'save'    ) ntpd_save();


echo gui_header($app_name);

echo '<br />'. "\n";

echo '<h2>'. $app_name .' Settings</h2>' ."\n";
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

echo '<h2>'. $app_name .' State</h2>' ."\n";
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

echo gui_footer();

?>
