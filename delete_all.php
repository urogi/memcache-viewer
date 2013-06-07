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

$slabs = $MEMCACHE->getStats('items');
foreach (array_keys($slabs['items']) as $slab_no){
	$items = $MEMCACHE->getStats('cachedump', $slab_no, $slabs['items'][$slab_no]['number']);
	foreach(array_keys($items) as $item_key) {
		$fs = fsockopen($config['SERVER']['SERVER'], $config['SERVER']['PORT']);
		fwrite($fs, 'delete ' . $item_key . "\r\n");
		fclose($fs);	
	}
}	 

header("Location: index.php");

?>
