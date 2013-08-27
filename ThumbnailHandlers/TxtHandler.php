<?php
$supported = array("txt", "md");
class TxtHandler extends ThumbnailHandler {

	function Info ($path, $fileName, $ext) {
		return "";
	}
	
	function generateThumbnail ($path, $fileName, $ext, $size) {
		$file = "$path". "/" . "$fileName" . "." . $ext;
		
		$file = fopen($file, "r");
		
		$thumb = imagecreatetruecolor($size, $size);
		$white = imagecolorallocate($thumb, 255, 255, 255);
		$grey  = imagecolorallocate($thumb, 128, 128, 128);
		$black = imagecolorallocate($thumb, 0, 0, 0);
		imagefilledrectangle($thumb, 0, 0, $size, $size, $white);
		
		$ypos = 0;
		while (($ypos <= $size) && (!feof($file))) {
			imagestring($thumb, 2, 0, $ypos, trim(str_replace("\t", "    ", fgets($file)), "\r\n"), $grey);
			$ypos += 12;
		}
		
		return $thumb;
	}
}
	
?>