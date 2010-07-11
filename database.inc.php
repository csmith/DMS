<?PHP

if (file_exists('settings.php')) {
 require('settings.php');
} else {
 define('DB_HOST', 'localhost');
 define('DB_USER', 'username');
 define('DB_PASS', 'password');
 define('DB_NAME', 'db_name');
}

mysql_connect(DB_HOST, DB_USER, DB_PASS);
mysql_select_db(DB_NAME);

function s($sql) { return mysql_real_escape_string($sql); }

?>
