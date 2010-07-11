<?PHP

function checkDir($dir, $prefix) {
 $files = glob($dir . '/*');
 $results = array();

 foreach ($files as $file) {
  $filename = (empty($prefix) ? '' : $prefix . '/') . basename($file);

  if (is_dir($file)) {
   $results = array_merge($results, checkDir($file, $filename));
  } else {
   $results[] = $filename;
  }
 }

 return $results;
}

?>
