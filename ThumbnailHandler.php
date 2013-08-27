<?php
abstract class ThumbnailHandler {
	
	function getInfo ($path, $fileName, $ext) {
		//This function returns all information that will be displayed next to the fileicon. It also handles the cache so please use the function Info to add additional information for a specific fileytpe
		
		$infoPath = $path . "/thumbs/" . $fileName . "." . $ext . ".info";
		$filePath = $path . "/" . $fileName . "." . $ext;
		$info = "";
		
		if (file_exists($infoPath) && (filemtime($infoPath) >= filemtime($filePath))) {
			$info = file_get_contents ($infoPath);
		}
		else {
			$info = $this->Info($path, $fileName, $ext);
			//Default information - will be displayed next to all files
			$info .= "<br>\n" . number_format(filesize($filePath), 0, ",", ".") . " Bytes";
			$info .= "<br>\n" . date ("d.m.Y H:i:s", filemtime($filePath));
			file_put_contents($infoPath, $info);
		}
		
		return $info;
	}
	
	function getImg ($path, $fileName, $ext, $size) {
		//This function returns a path to a thumbnail found on the Server. If it doesn't find one it calls generateThumbnail to get an image variable which will be cached and sent to the client
		//So again please use generateThumb to write your thumbnail-generation code you'll get cache for free ;)
		
		$thumbPath = $path . "/thumbs/" . $fileName . "." . $ext . "." . $size . ".jpg";
		$filePath = $path . "/" . $fileName . "." . $ext;
		
		if (!file_exists($thumbPath) || !(filemtime($thumbPath) >= filemtime($filePath))) {
			$thumb = $this->generateThumbnail($path, $fileName, $ext, $size);
			
			if (!$thumb) 
				$thumbPath = $this->getDefaultThumb($ext);
			else {
				imagejpeg ($thumb, $thumbPath, 95);
				imagedestroy($thumb);
			}
		}
		
		return $thumbPath;
	}
	
	//Fallback function to display a generic icon
	function getDefaultThumb($ext) {
		$ext = strtolower($ext);
		if (file_exists("icons/" . $ext . ".png"))
			return "icons/" . $ext . ".png";
		else
			return "icons/file.png";
	}
	
	//Your place to write your own info/thumbnail code
	abstract function Info ($path, $fileName, $ext);
	abstract function generateThumbnail ($path, $fileName, $ext, $size);
}
	
class IconHandler extends ThumbnailHandler {
	function getImg ($path, $fileName, $ext, $size) {
		return $this->getDefaultThumb($ext);
	}
	
	function Info ($path, $fileName, $ext) { return ""; }
	function generateThumbnail ($path, $fileName, $ext, $size) {}
}
?>