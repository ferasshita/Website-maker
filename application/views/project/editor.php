<?php
//include 'editor.php';
$html = file_get_contents('Asset/editor/editor.php');
$pid = $_GET['pid'];
$page = $_GET['page'];
$folder_pg = $_GET['folder'];
//search for html files in demo and my-pages folders
$pathh = "../projects/$pid/application/views/";

$htmlFiles = glob('{'.$pathh.'*\/*.php, '.$pathh.'*.php}',  GLOB_BRACE);
$files = '';
foreach ($htmlFiles as $file) {
   if (in_array($file, array('Asset/editor/new-page-blank-template.html', 'Asset/editor/editor.php'))) continue;//skip template files
   $pathInfo = pathinfo($file);
   $filename = $pathInfo['filename'];
   $file_extension = $pathInfo['extension'];
	//folder name ???
   $folder_name = dirname($file);
   $folder_name = basename($folder_name);
   $folder = preg_replace('@/.+?$@', '', $pathInfo['dirname']);
   $subfolder = preg_replace('@^.+?/@', '', $pathInfo['dirname']);
   if ($filename == 'index' && $subfolder) {
	   $filename = $subfolder;
   }
	$url = "http://localhost/projects/$pid/$folder_name/$filename";
	$file = "../../../projects/$pid/application/views/$folder_name/$filename.$file_extension";
   //$url = $pathInfo['dirname'] . '/' . $pathInfo['basename'];
   $name = ucfirst($filename);

  $files .= "{name:'$name', file:'$file', title:'$name',  url: '$url', folder:'$folder_name'},";
}
$pathh = "../projects/$pid/application/views/$folder_pg/";

$htmlFiles = glob('{'.$pathh. $page.'}',  GLOB_BRACE);
foreach ($htmlFiles as $file) {
	if (in_array($file, array('Asset/editor/new-page-blank-template.html', 'Asset/editor/editor.php'))) continue;//skip template files
	$pathInfo = pathinfo($file);
	$filename = $pathInfo['filename'];
	$file_extension = $pathInfo['extension'];
	//folder name ???
	$folder_name = dirname($file);
	$folder_name = basename($folder_name);
	$folder = preg_replace('@/.+?$@', '', $pathInfo['dirname']);
	$subfolder = preg_replace('@^.+?/@', '', $pathInfo['dirname']);
	if ($filename == 'index' && $subfolder) {
		$filename = $subfolder;
	}
	$url = "http://localhost/projects/$pid/$folder_name/$filename";
	$file = "../../../projects/$pid/application/views/$folder_name/$filename.$file_extension";
	//$url = $pathInfo['dirname'] . '/' . $pathInfo['basename'];
	$name = ucfirst($filename);

	$pa_val = "{name:'$name', file:'$file', title:'$name',  url: '$url', folder:'$folder_name'},";
}
//replace files list from html with the dynamic list from demo folder
$html = str_replace('(pages);', "([$files]);", $html);
$html = str_replace('(pa)', "$pa_val", $html);

echo $html;
