<?PHP

 function getLogoMatrix($logo) {
  $matrix = array();

  for ($x = 0; $x < imagesx($logo); $x++) {
   for ($y = 0; $y < imagesy($logo); $y++) {
    $c = imagecolorat($logo, $x, $y);
    $r = 255 * round((($c >> 16) & 0xFF) / 255, 0);
    $g = 255 * round((($c >>  8) & 0xFF) / 255, 0);
    $b = 255 * round(( $c        & 0xFF) / 255, 0);

    $xo = floor(10 * $x / imagesx($logo));
    $yo = floor( 5 * $y / imagesy($logo));

    if (!isset($matrix[$xo][$yo])) {
     $matrix[$xo][$yo] = array('r' => 0, 'g' => 0, 'b' => 0, 'c' => 0);
    }

    $matrix[$xo][$yo]['r'] += $r;
    $matrix[$xo][$yo]['g'] += $g;
    $matrix[$xo][$yo]['b'] += $b;
    $matrix[$xo][$yo]['c']++;
   }
  }

  $res = '';

  foreach ($matrix as $x => $row) {
   foreach ($row as $y => $data) {
    extract($data); 

    $r /= $c; $g /= $c; $b /= $c;
    $r = floor($r); $g = floor($g); $b = floor($b);
    $r = round($r / 127); $g = round($g / 127); $b = round($b / 127);
    $v = chr(ord('A') + $r + $g * 3 + $b * 6);
    $res .= $v; 
   }
  }

  return $res;
 }

?>
