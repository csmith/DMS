<?PHP

 set_time_limit(0);

 require_once('database.inc.php');
 require_once('cron.inc.php');
 require_once('logo.inc.php');
 require_once('logo.matrix.inc.php');

foreach (checkDir('docs', '') as $doc) {
 $sql = 'SELECT COUNT(*) FROM logoresults WHERE logo_image = \'' . s($doc) . '\'';
 $res = mysql_query($sql);
 $num = mysql_result($res, 0);

 if ($num == 0) {
  echo "Determining logo and matrix for $doc ... ";
  $image  = imagecreatefromjpeg('docs/' . $doc);
  $logo   = getLogo($image);
  $matrix = getLogoMatrix($logo);  

  ob_start();
  imagejpeg($logo);
  $logo = ob_get_contents();
  ob_end_clean();

  $sql  = 'INSERT INTO logoresults (logo_image, logo_logo, logo_matrix) VALUES (\'';
  $sql .= s($doc) . '\', \'' . s($logo) . '\', \'' . $matrix . '\')';
  mysql_query($sql);

  echo "Done\n";
 }
}

?>
