<?PHP

 require_once('database.inc.php');

 $image = $_POST['image'];
 
 if (!preg_match('/^([a-z]+\/)+[a-z]+[-_][0-9]+\.jpe?g$/', $image) || !file_exists($image)) {
  die('Error: ' . htmlentities($image));
 }

 $db = substr($image, 5);

 $sql = 'SELECT ocr_gocr, ocr_ocrad FROM ocrresults WHERE ocr_image = \'' . mysql_real_escape_string($db) . '\'';
 $res = mysql_query($sql);
 $row = mysql_fetch_assoc($res);

?>
<h2>OCR results</h2>
<h3>gOCR</h3>
<textarea><?PHP echo htmlentities($row['ocr_gocr']); ?></textarea>
<h3>OCRad</h3>
<textarea><?PHP echo htmlentities($row['ocr_ocrad']); ?></textarea>
