<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

isset($_SESSION['logged_in']) or die('You must be logged in to do this.');

$config = parse_ini_file('config.ini.php', true);

//get server and port setting. Die if non-existent
isset($config['SERVER']['SERVER']) or die('No SERVER configuration setting in the SERVER section of config.ini.');
define('SERVER', $config['SERVER']['SERVER']);

isset($config['SERVER']['PORT']) or die('No PORT configuration setting in the SERVER section of config.ini.');
define('PORT', $config['SERVER']['PORT']);

$MEMCACHE = new Memcache();
$MEMCACHE->pconnect(SERVER, PORT);

//set timezone
date_default_timezone_set(isset($config['MISC']['PHP_TIMEZONE'])
	? $config['MISC']['PHP_TIMEZONE']
	: 'Europe/London');

/*
 * OK, it's time to get the items and add them to our cache array.
 */

$key = $_GET['key'];
!empty($key) or die('Memcache cache for key = ' . $key . ' is empty.');

$value = $MEMCACHE->get($key);

echo '<link rel="stylesheet" type="text/css" href="css/TableViewer.css" />';
echo '<hr/><b>KEY:</b><hr/>';
echo '<font class="key_color">' . $key . '</font>';
echo '<br/><br/>';
echo '<hr/><b>VALUE:</b><hr/>';
if (is_array($value)) {
	echo '<font>' . var_dump($value) . '</font>';
} else {
	echo '<font>' . $value . '</font>';
	echo '<hr/><b>htmlspecialchars(VALUE):</b><hr/>';
	echo '<font class="html_value_color">' . htmlspecialchars($value) . '</font>';
}

?>
