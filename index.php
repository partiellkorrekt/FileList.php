<?php
require_once "FileView.php";
?>
<!doctype html>
<html>
<head>
	<title>Übersicht aller Dateien</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="default.css" />
</head>

<body>

<h1>Übersicht aller Dateien</h1>
<?php
	$fileDir = "files";
	$files = scandir($fileDir);
	
	$fileView = new FileView(100);
	$fileView->fileList($fileDir, $files, true);
?>
</body></html>