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

echo	"<xml version=\"1.0\" encoding=\"UTF-8\">\n" .
	"<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">\n" .
	"<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\">\n" .
	"\t<head>\n" .
	"\t\t<link type=\"text/css\" href=\"/userapp/css/beroApp.css\" rel=\"Stylesheet\" />\n" .
	"\t\t<link type=\"image/x-icon\" href=\"/app/berogui/includes/favicon.ico\" rel=\"Icon\" />\n" .
	"\t\t<title>" . $app_name . "</title>\n" .
	"\t</head>\n" .
	"\t<body>\n" .
	"\t\t<div class=\"main\">\n" .
	"\t\t\t<div class=\"top\"><img src=\"/app/berogui/includes/images/bg_top.png\" /></div>\n" .
	"\t\t\t<div class=\"left\">\n" .
	"\t\t\t\t<div>Menu: <a href=\"/app/berogui/\">berogui</a> | <a href=\"/userapp/\">UserApp Management</a></div>\n" .
	"\t\t\t\t<h1>" . $app_name . "</h1>\n";
	
	if ( $_GET['Start'] == "Start" ) {
		echo "\t\t\t\t" . 'Starting NTP Server<br>' ."\n";
		system($base_path . '/init/S01ntpd start >/dev/null');
		echo "\t\t\t\t" . 'NTP-Server started<br>' ."\n";
	}
	
	if ( $_GET['Stop'] == "Stop" ) {
		echo "\t\t\t\t" . 'Stopping NTP Server<br>' ."\n";
		system($base_path . '/init/S01ntpd stop >/dev/null');
		echo "\t\t\t\t" . 'NTP-Server stopped<br>' ."\n";
	}
	
echo	"\t\t\t\t<form name=\"restart\" action=\"". $_SERVER['PHP_SELF'] ."\" method=\"GET\">\n" .
	"\t\t\t\t\t<input type=\"submit\" name=\"Start\" value=\"Start\" /> \n" .
	"\t\t\t\t\t<input type=\"submit\" name=\"Stop\" value=\"Stop\" /> \n" .
	"\t\t\t\t</form>\n";
	
echo	"\t\t\t</div>\n" .
	"\t\t\t<div class=\"bottom\"><img src=\"/app/berogui/includes/images/bg_bottom.png\" /></div>\n" .
	"\t\t</div>\n" .
	"\t</body>\n" .
	"</html>\n";

?>
