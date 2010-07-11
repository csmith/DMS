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

if (!file_exists($image)) {
 
 /* TODO: Output error image. */
 
 die();
 
}

if (file_exists('.thumbs/prog-' . md5($image))) {
 $mtime = filemtime('.thumbs/prog-' . md5($image));
 if ($mtime >= filemtime($image)) {
  header('Content-type: image/jpeg');
  readfile('.thumbs/prog-' . md5($image));
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


header('Content-type: image/jpeg');
imageinterlace($imi, true);

imagejpeg($imi, '.thumbs/prog-' . md5($image), 100);
imagejpeg($imi, false, 100);

?>
