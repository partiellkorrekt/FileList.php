<?php
//Each class should be named after its filename and provide an array $supported of supported extensions like below
$supported = array("jpg", "png", "gif");

class ImageHandler extends ThumbnailHandler {

	function Info ($path, $fileName, $ext) {
		$file = "$path". "/" . "$fileName" . "." . $ext;
		$info = "";
		
		$size = getimagesize($file);
		$info .= $size[0] . "px × " . $size[1] . "px";
		
		return $info;
	}
	
	function generateThumbnail ($path, $fileName, $ext, $size) {
		$file = "$path". "/" . "$fileName" . "." . $ext;
		$ext = strtolower($ext);
		
		$oldSize = getimagesize($file);
		$width = $size;
		$height = $size;
		if ($oldSize[0] > $oldSize[1]) {
			$height = $oldSize[1] / $oldSize[0] * $height;
		} else {
			$width = $oldSize[0] / $oldSize[1] * $width;
		}
		
		if ($ext == 'jpg') $source = imagecreatefromjpeg($file);
		if ($ext == 'png') $source = imagecreatefrompng($file);
		if ($ext == 'gif') $source = imagecreatefromgif($file);
		
		$thumb = imagecreatetruecolor($width, $height);
		$white = imagecolorallocate($thumb, 255, 255, 255);
		imagefilledrectangle($thumb, 0, 0, $size, $size, $white);
		
		imagecopyresampled ($thumb, $source, 0, 0, 0, 0, $width, $height, $oldSize[0], $oldSize[1]);
		imagedestroy($source);
		
		return $thumb;
	}
}
	
?>