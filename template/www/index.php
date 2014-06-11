<?php

# Define functions below this line.
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


# execute Start/Stop
if (!empty($_GET['execute'])) {
	if ($_GET['execute'] == 'Start') exec($base_path . '/init/S01ntpd start >/dev/null');
	if ($_GET['execute'] == 'Stop' ) exec($base_path . '/init/S01ntpd stop >/dev/null');
}

# get pid if exists
$pid = exec('/bin/pidof -s ntpd');


echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">' ."\n";
echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">' ."\n";
echo "\t". '<head>' ."\n";
echo "\t\t". '<link type="text/css" href="/userapp/css/beroApp.css" rel="Stylesheet" />' ."\n";
echo "\t\t". '<link type="image/x-icon" href="/app/berogui/includes/images/favicon.ico" rel="Icon" />' ."\n";
echo "\t\t". '<title>' . $app_name . '</title>' ."\n";
echo "\t". '</head>' ."\n";
echo "\t". '<body>' ."\n";
echo "\t\t". '<div class="main">' ."\n";
echo "\t\t\t". '<div class="top"><img src="/app/berogui/includes/images/bg_top.png" /></div>' ."\n";
echo "\t\t\t". '<div class="left">' ."\n";
echo "\t\t\t\t". '<div>Menu: <a href="/app/berogui/">berogui</a> | <a href="/userapp/">UserApp Management</a></div>' ."\n";
echo "\t\t\t\t". '<h1>' . $app_name . ($pid ? ' is Running (pid: '. $pid .')' : ' is not Running') . '</h1>' ."\n";
echo "\t\t\t\t". '<form name="restart" action="'. $_SERVER['PHP_SELF'] .'" method="GET">' ."\n";
echo "\t\t\t\t\t". '<input type="submit" name="execute" value="Start" />' ."\n";
echo "\t\t\t\t\t". '<input type="submit" name="execute" value="Stop" />' ."\n";
echo "\t\t\t\t". '</form>' ."\n";
echo "\t\t\t". '</div>' ."\n";
echo "\t\t\t". '<div class="bottom"><img src="/app/berogui/includes/images/bg_bottom.png" /></div>' ."\n";
echo "\t\t". '</div>' ."\n";
echo "\t". '</body>' ."\n";
echo '</html>' ."\n";

?>
