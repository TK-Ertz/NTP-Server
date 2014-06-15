<?php

# Define functions below this line.

function gui_menu() {

	$ret  = '';
	$ret .= "\t\t\t\t\t". '<div style="text-align: center; height: 22px;">' ."\n";
	$ret .= "\t\t\t\t\t\t". '<div style="float: right;">' ."\n";
	$ret .= "\t\t\t\t\t\t\t". '<ul id="navmenu-h">' ."\n";
	$ret .= "\t\t\t\t\t\t\t\t". '<li><a href="/userapp/">UserApp Management</a></li>' ."\n";
	$ret .= "\t\t\t\t\t\t\t\t". '<li><a href="/app/berogui/">beroGUI</a></li>' ."\n";
	$ret .= "\t\t\t\t\t\t\t". '</ul>' ."\n";
	$ret .= "\t\t\t\t\t\t". '</div>' ."\n";
	$ret .= "\t\t\t\t\t". '</div>' ."\n";

	return $ret;
}

function gui_header($title) {

	$bg_inc = '/app/berogui/includes';

	$ret  = '';
	$ret .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">' ."\n";
	$ret .= '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">' ."\n";
	$ret .= "\t". '<head>' ."\n";
	$ret .= "\t\t". '<link type="text/css" href="/userapp/css/beroApp.css" rel="Stylesheet" />' ."\n";
	$ret .= "\t\t". '<link type="image/x-icon" href="/app/berogui/includes/images/favicon.ico" rel="Icon" />' ."\n";
	$ret .= "\t\t". '<title>' . $title . '</title>' ."\n";
	$ret .= "\t". '</head>' ."\n";
	$ret .= "\t". '<body>' ."\n";
	$ret .= "\t\t". '<div class="main">' ."\n";
	$ret .= "\t\t\t". '<div class="top"><img src="'. $bg_inc .'/images/bg_top.png" /></div>' ."\n";
	$ret .= "\t\t\t". '<div class="left">' ."\n";
	$ret .= "\t\t\t\t". '<img src="'. $bg_inc .'/images/berofixlogo.png" />' ."\n";
	$ret .= "\t\t\t\t". '<div style="width: 100%; text-align: center;">' ."\n";
	$ret .= "\t\t\t\t\t". '<hr style="height: 2px; color: gray; margin-bottom: 20px;" />' ."\n";
	$ret .= "\t\t\t\t\t". '<span style="background-color: transparent; color: gray; font-size: 30px;">'. $title .'</span>' ."\n";
	$ret .= "\t\t\t\t". '</div>' ."\n";
	$ret .= "\t\t\t\t". '<br /><br />' ."\n";
	$ret .= "\t\t\t\t". '<div class="content" style="margin-right: 32px">' ."\n";

	return $ret;
}

function gui_footer() {

	$ret  = '';
	$ret .= "\t\t\t\t". '</div>' ."\n";
	$ret .= "\t\t\t\t". '<div style="text-align: left;">' ."\n";
	$ret .= "\t\t\t\t\t". '<hr style="height: 2px; color: gray;" />' ."\n";
	$ret .= "\t\t\t\t\t". '<span style="background-color: transparent;">' ."\n";
	$ret .= "\t\t\t\t\t\t". '&copy; <a href="http://www.tk-ertz.de">TK- und IT-Service Ertz</a>' ."\n";
	$ret .= "\t\t\t\t\t". '</span>' ."\n";
	$ret .= "\t\t\t\t\t". '<div style="float: right; margin-right: 32px;">' ."\n";
	$ret .= "\t\t\t\t\t\t". '<a href="http://www.github.com/TK-Ertz/NTP-Server">GitHub</a>' ."\n";
	$ret .= "\t\t\t\t\t". '</div>' ."\n";
	$ret .= "\t\t\t\t". '</div>' ."\n";
	$ret .= "\t\t\t". '</div>' ."\n";
	$ret .= "\t\t\t". '<div class="bottom"><img src="/app/berogui/includes/images/bg_bottom.png" /></div>' ."\n";
	$ret .= "\t\t". '</div>' ."\n";
	$ret .= "\t". '</body>' ."\n";
	$ret .= '</html>' ."\n";

	return $ret;
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

$redir_login = '/app/berogui/includes/login.php';

@session_start();
if (!isset($_SESSION['beroari_time'])) {
	header('Location:' . $redir_login . '?userapp=' . $app_name);
	exit();
} elseif ((isset($_SESSION['beroari_time'])) && (($_SESSION['beroari_time'] + 1200) < time())) {
	@session_unset();
	@session_destroy();
	header('Location:' . $redir_login . '?reason=sess_expd&userapp=' . $app_name);
	exit();
}

unset($redir_login);

$_SESSION['beroari_time'] = time();

#  END session management  #


if (!empty($_GET['execute']) && $_GET['execute'] == 'services') ntpd_services($_GET['services']);
if (!empty($_GET['execute']) && $_GET['execute'] == 'save'    ) ntpd_save();


echo gui_header($app_name);
echo gui_menu();
echo "\t\t\t\t\t". '<h2>'. $app_name .' Settings</h2>' ."\n";
echo "\t\t\t\t\t". '<form class="confForm" name="ntpd_settings" action="index.php" method="GET">' ."\n";
echo "\t\t\t\t\t\t". '<div style="float: right;">' ."\n";
echo "\t\t\t\t\t\t\t". '<input type="hidden" name="execute" value="save" />' ."\n";
echo "\t\t\t\t\t\t\t". '<input type="submit" value="Apply" />' ."\n";
echo "\t\t\t\t\t\t". '</div>' ."\n";
echo "\t\t\t\t\t\t". '<div style="margin-left: 5px; float: left; width: 200px; font-weight: bold;">' ."\n";
echo "\t\t\t\t\t\t\t". 'Enable NTP-Server: '. "\n";
echo "\t\t\t\t\t\t". '</div>' ."\n";
echo "\t\t\t\t\t\t". '<div><input type="checkbox" name="enabled" value="1" '. (get_ntpd_enabled() ? ' checked' : '') .'/></div>' ."\n";
echo "\t\t\t\t\t". '</form>' ."\n";
echo "\t\t\t\t\t". '<h2>'. $app_name .' State</h2>' ."\n";
echo "\t\t\t\t\t". '<form class="confForm" name="ntpd_services" action="index.php" method="GET">' ."\n";
echo "\t\t\t\t\t\t". '<div style="float: right;">' ."\n";
echo "\t\t\t\t\t\t\t". '<input type="hidden" name="execute" value="services" />' ."\n";
echo "\t\t\t\t\t\t\t". '<input type="submit" name="services" value="start" />' ."\n";
echo "\t\t\t\t\t\t\t". '<input type="submit" name="services" value="stop" />' ."\n";
echo "\t\t\t\t\t\t\t". '<input type="submit" name="services" value="restart" />' ."\n";
echo "\t\t\t\t\t\t". '</div>' ."\n";
echo "\t\t\t\t\t". '</form>' ."\n";
echo "\t\t\t\t\t\t". '<div style="margin-left: 5px; font-weight: bold;">NTP-Server are currently ';
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
echo gui_footer();

?>
