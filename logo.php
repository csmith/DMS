<?PHP

 $image = $_POST['image'];
 
 if (!preg_match('/^([a-z]+\/)+[a-z]+[-_][0-9]+\.jpe?g$/', $image)) {
  die('Error: ' . htmlentities($image));
 }

?>
<h2>Logo detect</h2>
<h3>Detected logo</h3>
<?PHP

 if (file_exists('.logos/' . md5($image))) {
  echo '<img src=".logos/', md5($image), '">';
 }

?>
<h3>Documents with similar logos</h3>
<?PHP
 require_once('database.inc.php');

 $sql = 'SELECT logo_image, logo_matrix FROM logoresults WHERE LENGTH(logo_matrix) > 0';
 $res = mysql_query($sql);
 $data = array();

 while ($row = mysql_fetch_assoc($res)) {
  $data[$row['logo_image']] = $row['logo_matrix'];
 }

 $timage = substr($image, 5);

 if (isset($data[$timage])) {
  $target = $data[$timage];
  unset($data[$timage]);

  foreach ($data as $key => $value) {
   $data[$key] = levenshtein($value, $target);
  }

  asort($data);
  foreach ($data as $key => $value) {
   if ($value < 10) {
    echo '<div style="float: left; text-align: center; font-size: small;"><img src="thumb.php?', 'docs/', $key, '"><br>(', $value, ')</div>';
   }
  }
 }

?>
