<?PHP

 require_once('database.inc.php');

 if (isset($_POST['query'])) {
  $query = 'SELECT ocr_image,  MATCH(ocr_gocr, ocr_ocrad) AGAINST (\'' . mysql_real_escape_string($_POST['query']) . '\' IN BOOLEAN MODE) AS score FROM ocrresults WHERE MATCH(ocr_gocr, ocr_ocrad) AGAINST (\'' . mysql_real_escape_string($_POST['query']) . '\' IN BOOLEAN MODE) > 0 ORDER BY score DESC';
 } else {
  $query = 'SELECT ocr_image FROM ocrresults ORDER BY RAND()';
 }

 $sql = $query . ' LIMIT 0,42';
 $res = mysql_query($sql) or die(mysql_error());

 while ($row = mysql_fetch_assoc($res)) {
  echo '<div class="thumbnail">';
  echo '<img src="thumb.php?docs/' . $row['ocr_image'] . '" onmouseover="rollover(this);" onmouseout="rolloff(this);" onclick="click(this);">';
  echo '</div>';
 }

?>
