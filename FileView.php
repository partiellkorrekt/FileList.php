<?php
require_once "ThumbnailHandler.php";

class FileView {
	var $extensions;
	var $defaultHandler;
	var $thumbSize;
	var $showHiddenFiles = false;
	
	function __construct($thumbSize = 200, $showHiddenFiles = false) {
		require_once("ThumbnailHandler.php");
		$this->thumbSize = $thumbSize;
		$this->showHiddenFiles = $showHiddenFiles;
		//readExtensions
		$this->extensions = array();
		$this->defaultHandler = new IconHandler();
		$handlerNames = scandir("ThumbnailHandlers");
		foreach ($handlerNames as $name)
			if (preg_match("#(.*)\.php#", $name, $parts)) {
				require_once("ThumbnailHandlers/".$name);
				$className = $parts[1];
				foreach ($supported as $ext)
					$this->extensions[$ext] = new $className();
			}
	}

	function fileList($fileDir, $files, $echoDirect = false) {
		//If echoDirect is true, FileItems will be sent to the client immediately instead of caching and returning them. This may result in a better experience if a lot of Thumbnails have to be generated as the user needen't wait for the whole process to complete to see the first files
		$result = '';
		//Loop through the given files
		foreach ($files as $file) {
			//Find the right ThumbnailHandler
			$handler = $this->defaultHandler;
			if (preg_match("/(.*)\.(".implode("|", array_keys($this->extensions)).")$/i", $file, $parts)) {
				//We have a special Thumbnail-Handler so call it
				$handler = $this->extensions[strtolower($parts[2])];
			}
			
			//Print the FileItem if the filename is valid
			$regex = $this->showHiddenFiles ? "/(.*)\.([\w|\d]+)$/i" : "/([\w|\d].*)\.([\w|\d]+)$/i";
			if (preg_match($regex, $file, $parts)) {
				$thumb_image = $handler->getImg($fileDir, $parts[1], $parts[2], $this->thumbSize);
				$file_info = $handler->getInfo($fileDir, $parts[1], $parts[2]);
				$result .= $this->fileItem($fileDir. "/" . $file, $file, $thumb_image, $file_info);
			}
			
			if ($echoDirect) {
				echo $result;
				$result = '';
			}
		}
		
		return $result;
	}
	
	function fileItem($link, $name, $image, $info) {
		//This Function is kind of a HTML-Tamplate for a single file - I know this can be done better but I don't care :P
		return '
		<div class="file_rep">
			<div class="thumb_container" style="height: ' . $this->thumbSize . 'px; width: ' . $this->thumbSize .'px;">
				<img class="thumbnail" src="' . $image . '" style="max-height: ' . $this->thumbSize . 'px; max-width: ' . $this->thumbSize . 'px;" />
			</div>
			<a href="' . $link . '">' . $name . '</a><br />
			' . $info . '
		</div>';
	}
}
?>