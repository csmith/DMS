<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <title>Document Management</title>
 </head>
 <body>
  <div id="searchresults">
<?PHP

 foreach (glob('.logos/*') as $logo) {
  echo '<img src="', $logo, '" style="float: left;">';
 }

?>
  </div>
 </body>
</html>
