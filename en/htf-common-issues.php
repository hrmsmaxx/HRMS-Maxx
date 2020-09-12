#!/usr/bin/php -q
<?php

/**
 * Howtoforge common-issues-checker (c) 2013 - M. Cramer <m.cramer@pixcept.de>
 * Version 0.5
 */


define('DEBUG', false);
define('ANONYMIZE', true);
define('REPORT_FILE', './htf_report.txt');
define('POSTFIX_MASTER', '/etc/postfix/master.cf') ;

if(isset($argv[1]) && $argv[1] == '--debug') define('OUTPUT', true);
else define('OUTPUT', false);

$netstat_out = '';
$iptables_out = '';
$ifconfig_out = '';

if(!function_exists('readline')) {
	function readline($prompt = '') {
		print $prompt;
		return rtrim(fgets(STDIN), "\n");
	}

}

// clean up report file
$fp = fopen(REPORT_FILE, 'w');
fclose($fp);

function outlog($line, $anonymize = true) {
	if(OUTPUT == true) print $line . "\n";
	$fp = fopen(REPORT_FILE, 'a');
	fwrite($fp, ($anonymize ? anonip($line) : $line) . "\n");
	fclose($fp);
}

function anonip($data) {
	if(ANONYMIZE == false) return $data;

	$data = preg_replace('/(\D)0\.0\.0\.0(\D)/', '$1[anywhere]$2', $data);
	$data = preg_replace('/(127\.0\.0\.1|(\D):::1)/', '$2[localhost]', $data);
	$data = preg_replace('/(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})/', '***.***.***.***', $data);
	$data = preg_replace('/(\:\:([a-f0-9]{1,4}\:){0,6}?[a-f0-9]{0,4}|[a-f0-9]{1,4}(\:[a-f0-9]{1,4}){0,6}?\:\:|[a-f0-9]{1,4}(\:[a-f0-9]{1,4}){1,6}?\:\:([a-f0-9]{1,4}\:){1,6}?[a-f0-9]{1,4})(\/\d{1,3})?/', '*:*:*:*::*', $data);
	return $data;
}

function checkport($port, $name) {
	global $netstat_out, $iptables_out;

	$ok = preg_match('/:' . $port . '\s/', $netstat_out);
	if(!$ok) {
		outlog("[WARN] Port $port ($name) seems NOT to be listening");
	} else {
		if(DEBUG == true) {
			outlog("[OK] Port $port ($name) seems to be listening");
		}
	}

	$ok = preg_match('/DROP.*(dpt:' . $port . '\b|dports.*\b' . $port . '\b)/', $iptables_out);
	if($ok) {
		outlog("[WARN] Port $port ($name) seems to be BLOCKED in firewall");
	} else {
		if(DEBUG == true) {
			outlog("[OK] Port $port ($name) seems to be available");
		}
	}
}

function processname($name) {
	switch($name) {
		case 'apache2':
		case 'httpd2':
			return 'Apache 2';
		case 'lighttpd':
			return 'lighttpd';
		case 'nginx':
			return 'Nginx';
		case 'mysql':
			return 'MySQL Server';
		case 'courier':
		case 'courier-pop3':
		case 'courier-imap':
		case 'courier-pop3-ssl':
		case 'courier-imap-ssl':
		case 'couriertcpd':
			return 'Courier Mailserver';
		case 'dovecot':
		case 'pop3-login':
		case 'imap-login':
			return 'Dovecot';
		case 'master':
			return 'Postfix';
		case 'sendmail':
		case 'sendmail-':
			return 'Sendmail';
		case 'exim':
		case 'exim4':
			return 'Exim';
		case 'proftpd':
			return 'ProFTP';
		case 'pure-ftpd':
			return 'PureFTP';
		default:
			return 'Unknown process (' . $name . ')';
	}
}

function checkservice($port) {
	global $netstat_out;
	
	$services = array();
	$ok = preg_match_all('/:' . $port . '\s+\((\d+)\/(\S+)\)/', $netstat_out, $match, PREG_SET_ORDER);
	if($ok) {
		foreach($match as $set) {
			$name = $set[2];
			if(!isset($services[$name])) {
				$services[$name] = array('name' => processname($name), 'pid' => $set[1]);
			} else {
				if(preg_match('/(^|,)' . $set[1] . '(,|$)/', $services[$name]['pid']) == false) $services[$name]['pid'] .= ', ' . $set[1];
			}
		}
	}
	return $services;
}


/* MAIN PROGRAM STARTS */

$has_ispconfig = false;


// check for listening ports
$netstat_out = shell_exec('netstat -ntlp | awk \'{print $4 "\t\t(" $7 ")"}\' 2>/dev/null');
$iptables_out = shell_exec('iptables -L -n 2>/dev/null');
$ifconfig_out = shell_exec('ifconfig 2>/dev/null');

outlog("\n##### SERVER #####");

$ips = array();
// try to find main ip of server
$ok = preg_match_all('/encap:Ethernet.*?inet\s+\w+:(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})\s+/s', $ifconfig_out, $match, PREG_SET_ORDER);
if($ok) {
	foreach($match as $set) {
		$ips[] = $set[1];
	}
}

$ip_address = gethostbyname(gethostname());
if(!$ip_address) {
	outlog("[WARN] could not determine server's ip address by hostname");
} else {
	outlog("IP-address (as per hostname): {$ip_address}");
}

if(count($ips) > 0) {
	outlog("IP-address(es) (as per ifconfig): " . implode(', ', $ips));
} else {
	outlog("[WARN] could not determine server's ip address by ifconfig");
}

if($ip_address && count($ips) > 0 && in_array($ip_address, $ips, true) == false) {
	outlog("[WARN] ip addresses from hostname differ from ifconfig output. Please check your ip settings.");
}

// Check OS version
$lsbrel='/usr/bin/lsb_release';
$rhatrel = '/etc/redhat-release';
$osrelease='/etc/os-release';
$suserel = '/etc/SuSE-release';
$gentoorel = '/etc/gentoo-release';

if (file_exists($lsbrel)) {
    $os_version = shell_exec($lsbrel.' -d -s');
} elseif (file_exists($rhatrel)) {
    $os_version = shell_exec('cat '.$redhatrel);
} elseif (file_exists($suserel)) {
    $os_version = shell_exec('cat '.$suserel);
} elseif (file_exists($gentoorel)) {
    $os_version = shell_exec('cat '.$gentoorel);
} elseif (file_exists($osrelease)) {
    $os_version = shell_exec('cat '.$osrelease.' | grep "PRETTY_NAME" | cut --characters=13-');
} else {
    $lslisting = shell_exec('ls -lhd /etc/*versio* /etc/*releas* /etc/*issue*');
}

if ($os_version == '') {
  outlog("ls listing to help show OS:\n".$lslisting);
} else {
  outlog("[INFO] OS version is $os_version ");
}

// check for ISPConfig
if(@is_dir("/usr/local/ispconfig")) $has_ispconfig = true;


if($has_ispconfig) {
	outlog("[INFO] ISPConfig is installed.");
	if(!@is_readable('/usr/local/ispconfig/server/lib/config.inc.php')) {
		outlog("[WARN] /usr/local/ispconfig/server/lib/config.inc.php is missing.");
	} else {
		include '/usr/local/ispconfig/server/lib/config.inc.php';
		outlog("\n##### ISPCONFIG #####\nISPConfig version is " . ISPC_APP_VERSION . "\n", false);
		if(!@is_readable('/usr/local/ispconfig/server/lib/mysql_clientdb.conf')) {
			outlog("[WARN] /usr/local/ispconfig/server/lib/mysql_clientdb.conf is missing.");
		} else {
			include '/usr/local/ispconfig/server/lib/mysql_clientdb.conf';

			// make db check
			$res = mysqli_connect($clientdb_host, $clientdb_user, $clientdb_password);
			if(!$res) {
				outlog("[WARN] Could not connect to mysql with given user data.");
			} else {
				$ok = mysqli_select_db($res, $conf['db_database']);
				if(!$ok) {
					outlog("[WARN] Could not open configured ISPConfig database ({$conf['db_database']}).");
				}
				mysqli_close($res);
			}
			
			$retcode = 0;
			$retout = array();
			if($clientdb_password) {
				exec('mysql -h ' . escapeshellarg($clientdb_host) . ' -u ' . escapeshellarg($clientdb_user) . ' -D ' . escapeshellarg($conf['db_database']) . ' -p' . escapeshellarg($clientdb_password) . ' -e "SHOW TABLES"', $retout, $retcode);
			} else {
				exec('mysql -h ' . escapeshellarg($clientdb_host) . ' -u ' . escapeshellarg($clientdb_user) . ' -D ' . escapeshellarg($conf['db_database']) . ' -e "SHOW TABLES"', $retout, $retcode);
			}
			if($retcode != 0) {
				outlog("[WARN] Could not use mysql command line to connect to the database. Check your mysql config!");
			}
		}
		
		// try to check connection to interface
		if($ip_address) {
			
			
		}
	}
} else {
	outlog("[INFO] No ISPConfig found.");
}

outlog("\n##### VERSION CHECK #####\n");
$php_version = phpversion();
outlog("[INFO] php (cli) version is $php_version");

$php_cgi_version = false;
if(is_file('/usr/lib/cgi-bin/php5') || is_link('/usr/lib/cgi-bin/php5')) {
	$check = shell_exec('/usr/lib/cgi-bin/php5 -v');
	$ok = preg_match('/^PHP\s+((\d+)\.(\d+)\.(\d+)((?:-\d+)?\+\w+\d+))\s+/', $check, $match);
	if($ok) {
		$php_cgi_version = $match[1];
		outlog("[INFO] php-cgi (used for cgi php in default vhost!) is version $php_cgi_version");
		if($match[2] < 5) {
			outlog("[WARN] Are you kidding? Still PHP 4???");
		} elseif(($match[2] == 5 && $match[3] < 3) || ($match[2] == 5 && $match[3] == 3 && ($match[4] < 12 && ($match[4] != 3 || !preg_match('/^-7\+squeeze1[67]$/', $match[5]))))) {
			outlog("[WARN] Your php-cgi in /usr/lib/cgi-bin/ seems to be outdated and might contain a known exploit ($match[5])!");
		} elseif($match[2] == 5 && $match[3] == 4 && $match[4] < 2) {
			outlog("[WARN] Your php-cgi in /usr/lib/cgi-bin/ seems to be outdated and might contain a known exploit!");
		}
	}
}


outlog("\n##### PORT CHECK #####\n");

// check if port 8080 is listening if ISPConfig is installed
if($has_ispconfig) {
	checkport(8080, "ISPConfig");
	checkport(8081, "ISPConfig Apps");
}

// check for common ports
checkport(80, "Webserver");
checkport(443, "Webserver SSL");
checkport(143, "IMAP server");
checkport(993, "IMAP server SSL");
checkport(110, "POP3 server");
checkport(995, "POP3 server SSL");
checkport(25, "SMTP server");
checkport(465, "SMTP server SSL");
checkport(21, "FTP server");
checkport(22, "SSH server");
checkport(25, "SMTP server");

// check for entries in master.cf

outlog("\n##### MAIL SERVER CHECK #####\n");


$FILE = file_get_contents(POSTFIX_MASTER);

$ok = preg_match('/^smtp\s+inet\s/m', $FILE);
if(!$ok) {
	outlog("[WARN] I found no \"smtp\" entry in your postfix master.cf");
}

$ok = preg_match('/^submission\s+inet\s/m', $FILE);
if(!$ok) {
	outlog("[WARN] I found no \"submission\" entry in your postfix master.cf");
	outlog("[INFO] this is not critical, but if you want to offer port 587 for smtp connections you have to enable this.");
}

$ok = preg_match('/^smtps\s+inet\s/m', $FILE);
if(!$ok) {
	outlog("[WARN] I found no \"smtps\" entry in your postfix master.cf");
	outlog("[INFO] this is not critical, but if you want to offer SSL for smtp (not TLS) connections you have to enable this.");
}


outlog("\n##### RUNNING SERVER PROCESSES #####\n");

$check_services = array('web server' => 80,
						'mail server' => 25,
						'pop3 server' => 110,
						'imap server' => 143,
						'ftp server' => 21);

foreach($check_services as $name => $port) {
	$servers = checkservice($port);
	if(count($servers) < 1) {
		outlog("[WARN] I could not determine which " . $name . " is running.");
	} else {
		$out = "[INFO] I found the following " . $name . "(s):";
		foreach($servers as $server) {
			$out .= "\n\t";
			$out .= $server['name'] . ' (PID ' . $server['pid'] . ')';
		}
		outlog($out);
	}
}

outlog("\n##### LISTENING PORTS #####\n" . $netstat_out . "\n\n");
outlog("\n##### IPTABLES #####\n" . $iptables_out . "\n\n");

if(OUTPUT == false) {
	print "\n##### SCRIPT FINISHED #####\n";
	print "Results can be found in htf_report.txt\n";
	print "To view results use your favourite text editor or type 'cat htf_report.txt | more' on the server console.\n";
	print "\nIf you want to see the non-anonymized output start the script with --debug as parameter (php -q htf-common-issues.php --debug).\n\n";
}

exit;
