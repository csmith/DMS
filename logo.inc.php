<?PHP

 function isClear(&$im, $x, $y) {
  $rgb = imagecolorat($im, $x, $y);
  $r = ($rgb >> 16) & 0xFF;
  $g = ($rgb >> 8) & 0xFF;
  $b = $rgb & 0xFF;

  return $r + $g + $b > 600;
 }

 function getLineScore(&$im, $y, $xmin, $xmax) {
  $count = 0;

  for ($x = $xmin; $x < $xmax; $x++) {
   if (isClear($im, $x, $y)) {
    $count++; 
   }
  }

  return $count / ($xmax - $xmin);
 }

 function getColScore(&$im, $ymin, $ymax, $x) {
  $count = 0;

  for ($y = $ymin; $y < $ymax; $y++) {
   if (isClear($im, $x, $y)) {
    $count++;
   }
  }

  return $count / ($ymax - $ymin);
 }

 // Number of blank lines required in a row
 define('BLANK_THRESHOLD', 15);

 function doBlankCols(&$im, $ymin, $ymax, $xmin, $xmax, $colour = false) {
  // Check for blank columns

  if ($xmin == $xmax || $ymin == $ymax) { return array(); }

  $lastx = $laststreak = -100; $count = 0; $res = array();

  for ($x = $xmin; $x <= $xmax; $x++) {
   $score = getColScore($im, $ymin, $ymax, $x);

   if ($score > 0.99) {
    if (++$lastx == $x) {
     $count++;

     if ($count == BLANK_THRESHOLD) {
      if ($colour) { imagefilledrectangle($im, $x - $count, $ymin, $x, $ymax, imagecolorallocatealpha($im, 0, 0, 0, 50));  }

      $res = array_merge($res, doBlankLines($im, $ymin, $ymax, max($xmin, $laststreak + 1), $x - $count - 1, $colour));

      $laststreak = $x;
     } else if ($count > BLANK_THRESHOLD) {
      if ($colour) { imageline($im, $x, $ymin, $x, $ymax, imagecolorallocatealpha($im, 0, 0, 0, 50)); }
      $laststreak = $x;
     }
    } else {
     $lastx = $x;
     $count = 1;
    }
   }
  }

  if (count($res) > 0 && $laststreak + 1 < $xmax) {
   $res = array_merge($res, doBlankLines($im, $ymin, $ymax, max($xmin, $laststreak + 1), $xmax));
  }

  if (count($res) == 0) {
   $res[] = array($ymin, $ymax, $xmin, $xmax);
  }

  return $res;
 }

 function doBlankLines(&$im, $ymin, $ymax, $xmin, $xmax, $colour = false) {
  // Check for blank lines

  if ($xmin == $xmax || $ymin == $ymax) { return array(); }

  $lasty = $laststreak = -100; $count = 0; $res = array();

  for ($y = $ymin; $y <= $ymax; $y++) {
   $score = getLineScore($im, $y, $xmin, $xmax);

   if ($xmin > 0) {
    //imageline($im, $xmin, $y, $xmax, $y, imagecolorallocatealpha($im, 0, 0xFF * $score, 0, 50));
   }

   if ($score > 0.99) {
    if (++$lasty == $y) {
     $count++;
 
     if ($count == BLANK_THRESHOLD) {
      if ($colour) {
       imagefilledrectangle($im, $xmin, $y - $count, $xmax, $y, imagecolorallocatealpha($im, 0, 0xFF, 0, 50));
      }

      $res = array_merge($res, doBlankCols($im, max($ymin, 1 + $laststreak), $y - $count, $xmin, $xmax, $colour));
     
      $laststreak = $y;
     } else if ($count > BLANK_THRESHOLD) {
      if ($colour) { imageline($im, $xmin, $y, $xmax, $y, imagecolorallocatealpha($im, 0, 0xFF, 0, 50)); }

      $laststreak = $y;
     }
    } else {
     $count = 1;
     $lasty = $y;
    }
   }
  }

  if (count($res) > 0 && $laststreak + 1 < $ymax) {
   $res = array_merge($res, doBlankCols($im, max($ymin, 1 + $laststreak), $ymax, $xmin, $xmax));
  }

  if (count($res) == 0) {
   $res[] = array($ymin, $ymax, $xmin, $xmax);
  }

  return $res;
 }

 function logoFilter1($logo) {
  global $im;

  $height = $logo[1] - $logo[0];
  $width = $logo[3] - $logo[2];
  
  if ($width < 3 * BLANK_THRESHOLD || $height < 3 * BLANK_THRESHOLD) { return false; }
  if ($width > 0.4 * imagesx($im)) { return false; }

  return true;
 }

 function logoFilter2($logo) {
  global $im, $logos;

  $left = $logo[2] < 0.5 * imagesx($im);

  foreach ($logos as $other) {
   if (($left && $other[2] < $logo[2] - 20) || (!$left && $other[3] > $logo[3] + 20)) {
    return false;
   }
  }

  return true;
 }

 function logoFilter3($logo) {
  global $logos;

  foreach ($logos as $other) {
   if ($other[0] < $logo[0]) { return false; }
  }

  return true;
 }

 function getLogo($im) {
  $logos = doBlankLines($im, 0, imagesy($im) / 3, 0, imagesx($im), false);

  $GLOBALS['im'] =& $im;
  $GLOBALS['logos'] =& $logos;

  $logos = array_filter($logos, 'logoFilter1');
  $logos = array_filter($logos, 'logoFilter2');
  $logos = array_filter($logos, 'logoFilter3');

  $logo = array_pop($logos);
  $im2 = imagecreatetruecolor($logo[3] - $logo[2], $logo[1] - $logo[0]);
  imagecopy($im2, $im, 0, 0, $logo[2], $logo[0], $logo[3] - $logo[2], $logo[1] - $logo[0]);

  return $im2;
 }
?>
