<?php
require_once "FileView.php";
?>
<!doctype html>
<html>
<head>
	<title>Overview over your Files</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="default.css" />
</head>

<body>

<h1>Overview over your Files</h1>
<?php
	$fileDir = "files";
	$files = scandir($fileDir);
	
	$fileView = new FileView(100);
	$fileView->fileList($fileDir, $files, true);
?>
</body></html>