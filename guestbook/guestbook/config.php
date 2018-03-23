<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', '123456');
define('DB_NAME', 'guestbook');
define('GB_TABLE_NAME', 'guestbook');
define('ADMIN_TABLE_NAME', 'user');
define('PER_PAGE_GB', 5);

$debug = true;
if ($debug) {
	ini_set("display_errors", 1);
	error_reporting(E_ALL);
}
/**end of file**/