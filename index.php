<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <title>Document Management</title>
  <script src="res/prototype.js" type="text/javascript"></script>
  <script src="res/scriptaculous.js" type="text/javascript"></script>
  <script src="res/lightbox.js" type="text/javascript"></script>
  <script src="res/dms.js" type="text/javascript"></script>
  <link rel="stylesheet" href="res/style.css" type="text/css">
  <link rel="stylesheet" href="res/lightbox.css" type="text/css">
 </head>
 <body>
  <div id="search">
   Search: <input type="text" id="search_text" onkeypress="doSearch();">
   <img src="res/throbber.gif" id="search_throbber" style="visibility: hidden; vertical-align: middle;">
  </div>
  <div id="searchresults">
   <?PHP include('search.php'); ?>
  </div>
  <ul id="previewtabs">
   <li><a href="#" id="preview_preview" class="active" onclick="showTab('preview');">Preview</a></li>
   <li><a href="#" id="preview_info" onclick="showTab('info');">Image info</a></li>
   <li><a href="#" id="preview_ocr" onclick="showTab('ocr');">OCR results</a></li>
   <li><a href="#" id="preview_logo" onclick="showTab('logo');">Logo detect</a></li>
  </ul>
  <div class="preview" id="info"></div>
  <div class="preview" id="ocr"></div>
  <div class="preview" id="logo"></div>
  <div class="preview" id="preview"><a id="previewlink" href="" rel="lightbox"><img id="previewimg"></a></div>
 </body>
</html>
