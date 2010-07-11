<?PHP

require_once('database.inc.php');
require_once('cron.inc.php');

foreach (checkDir('docs', '') as $doc) {
 $sql = 'SELECT COUNT(*) FROM ocrresults WHERE ocr_image = \'' . $doc . '\'';
 $res = mysql_query($sql);
 $num = mysql_result($res, 0);

 if ($num == 0) {
  echo "OCRing $doc...\n";
  $gocr = `djpeg -pnm 'docs/$doc' | gocr -`;
  $ocrd = `djpeg -pnm 'docs/$doc' | ocrad`;

  $sql  = 'INSERT INTO ocrresults (ocr_image, ocr_gocr, ocr_ocrad) VALUES (\'' . $doc . '\', \'';
  $sql .= mysql_real_escape_string($gocr) . '\', \'' . mysql_real_escape_string($ocrd) . '\')';
  mysql_query($sql);
 } 
}

?>
