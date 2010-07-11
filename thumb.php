<?PHP

/******************************************************************************\

 thumb.php: Generate thumbnail image of specified file.
 Copyright (C) 2004-2007 Chris 'MD87' Smith

 This program is free software; you can redistribute it and/or
 modify it under the terms of the GNU General Public License
 as published by the Free Software Foundation; either version 2
 of the License, or (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

|******************************************************************************|

 Usage:
 
  <img src="thumb.php?file_name.png"...>
  
  <img src="thumb.php?directory/file.jpg"...>
  
  <img src="thumb.php?http://www.example.com/file.jpg"...>


\******************************************************************************/

header('Cache-control: public');

$image = $_SERVER['QUERY_STRING'];

if (substr($image, 0, 6) == 'large:') {
 define('LARGE', true);
 $image = substr($image, 6);
} else {
 define('LARGE', false);
}

define('THUMB_WIDTH', LARGE ? 240 : 80);               // Maximum width for thumbnails
define('THUMB_HEIGHT',LARGE ? 300 : 100);              // Maximum height for thumbnails
define('THUMB_BACK','255,255,255');      // Background colour

if (!file_exists($image)) {
 
 /* TODO: Output error image. */
 
 die();
 
}

if (file_exists('.thumbs/' . (LARGE ? 'large-' : '') . md5($image))) {
 $mtime = filemtime('.thumbs/' . (LARGE ? 'large-' : '') . md5($image));
 if ($mtime >= filemtime($image)) {
  header('Content-type: image/jpeg');
  readfile('.thumbs/' . (LARGE ? 'large-' : '') . md5($image));
  exit;
 }
}

/* TODO: Optimise. */


if (($imi = @imagecreatefromjpeg($image)) === FALSE) {
 
 if (($imi = @imagecreatefrompng($image)) === FALSE) {
  
  if (($imi = @imagecreatefromgif($image)) === FALSE) {
   
   /* TODO: Output error image. */
   
   die();
   
  }
  
 }
 
}

$width = imagesx($imi); $height = imagesy($imi);

$Rwidth = (THUMB_WIDTH/$width);
$Rheight = (THUMB_HEIGHT/$height);

if ($Rwidth > $Rheight) { $ratio = $Rheight; } else { $ratio = $Rwidth; }

if ($width > THUMB_WIDTH || $height > THUMB_HEIGHT) {
 $Nwidth = $width * $ratio;
 $Nheight = $height * $ratio;
} else {
 $Nheight = $height;
 $Nwidth = $width;
}

$imo = imagecreatetruecolor(THUMB_WIDTH, LARGE ? $Nheight : THUMB_HEIGHT);

$colour = explode(',',THUMB_BACK);

imagefill($imo,1,1,imagecolorallocate($imo,$colour[0],$colour[1],$colour[2]));

imagecopyresampled($imo,$imi,(THUMB_WIDTH-$Nwidth)/2 , LARGE ? 0 : (THUMB_HEIGHT-$Nheight)/2, 0, 0, $Nwidth, $Nheight, $width, $height);

header('Content-type: image/jpeg');

imagejpeg($imo, '.thumbs/' . (LARGE ? 'large-' : '') . md5($image), 100);
imagejpeg($imo, false, 100);

?>
