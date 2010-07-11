<?PHP

 $image = $_POST['image'];
 
 if (!preg_match('/^([a-z]+\/)+[a-z]+[-_][0-9]+\.jpe?g$/', $image)) {
  die('Error: ' . htmlentities($image));
 }

?>
<h2>Image information</h2>
<table>
 <tr>
  <th>Path</th>
  <td><?PHP echo htmlentities($image); ?></td>
 </tr>
 <tr>
  <th>Creation time</th>
  <td><?PHP echo date('r', filemtime($image)); ?></td>
 </tr>
 <tr>
  <th>File size</th>
  <td><?PHP echo number_format(filesize($image)); ?> B</td>
 </tr>
</table>
<h2>Related documents</h2>
<h3>Documents scanned at same time</h3>
<p>(Not implemented yet)</p>
<h3>Other pages in this document</h3>
<p>(Not implemented yet)</p>
