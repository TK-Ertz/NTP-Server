<?php

class NTP {

	private $_conffile;
	private $_initfile;
	
	public function __construct() {
		$this->_conffile = '/apps/NTP-Server/etc/ntpd';
		$this->_initfile = '/apps/NTP-Server/init/S01ntpd';
	}

	public function get_version() {
			if (file_exists('/apps/NTP-Server/VERSION')) {
			foreach(file('/apps/NTP-Server/VERSION/') as $line) {
				if (preg_match('/VERSION=([0-9]*)/', $line, $res)) {
					return $res[1];
				}
			}
		}
		return 'unknown';
	}

	public function is_enabled() {
		if ($fp = @fopen($this->_conffile, 'r')) {
			$cont = fread($fp, filesize($this->_conffile));
			return (strstr($cont, 'NTPD_ENABLED=yes') ? true : false);
		}
		return false;
	}

	public function is_running() {
		if (exec('/bin/pidof -s ntpd')) {
			return true;
		} else {
			return false;
		}
	}

	private function _save_conf($enabled) {
		if ($fp = @fopen($this->_conffile, 'w')) {
			$line = 'NTPD_ENABLED='. ($enabled == 1 ? 'yes' : 'no') ."\n";
			fwrite($fp, $line);
			chown($this->_conffile, 'admin');
			chgrp($this->_conffile, 'admin');
			$this->restart();
			return true;
		} else {
			return false;
		}
	}

	public function set_enabled() {
		return $this->_save_conf(true);
	}

	public function set_disabled() {
		return $this->_save_conf(false);
	}

	public function start() {
		exec($this->_initfile .' start >/dev/null');
		usleep(200000);
	}

	public function stop() {
		exec($this->_initfile .' stop >/dev/null');
		usleep(200000);
	}

	public function restart() {
		exec($this->_initfile .' restart >/dev/null');
		usleep(200000);
	}

}

?>
