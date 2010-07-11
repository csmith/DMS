var lastImage = null;
var searchTO = null;

function click(image) {
 document.getElementById('previewimg').src = image.src.replace(/thumb/, 'prog');
 document.getElementById('previewlink').href = document.getElementById('previewimg').src;

 if (lastImage != null) {
  lastImage.style.opacity = 1.0;
 }

 image.style.opacity = 0.5;
 image.parentNode.style.backgroundColor = 'red';
 lastImage = image;

 var name = image.src.replace(/^.*?thumb\.php\?/, '');
 new Ajax.Updater('info', 'info.php', {parameters: {image: name}, asynchronous: true});
 new Ajax.Updater('ocr', 'ocr.php', {parameters: {image: name}, asynchronous: true});
 new Ajax.Updater('logo', 'logo.php', {parameters: {image: name}, asynchronous: true});
}

function doSearch() {
 if (searchTO != null) {
  clearTimeout(searchTO);
 }

 $('search_throbber').style.visibility = 'visible';
 searchTO = setTimeout(doSearch2, 1000);
}

function doSearch2() {
 var term = $('search_text').value;
 new Ajax.Updater('searchresults', 'search.php', {parameters: {query: term}, asynchronous: true, onComplete: doneSearch});
}

function doneSearch() {
 $('search_throbber').style.visibility = 'hidden';
}

function showTab(what) {
 $$('#previewtabs a').each(function(e) {
  e.className = '';
 });

 $('preview_' + what).className = 'active';

 $$('.preview').each(function(e) {
  e.style.zIndex = 0;
 });

 $(what).style.zIndex = 10;
}
