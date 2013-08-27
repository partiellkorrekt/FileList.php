FileList.php
============

A small PHP-Class to display a lot of files with thumbnails

## What FileList.php does
FileList.php generates a website from all your files in /files with thumbnails. It uses /files/thumbs as a cache.
The cache should be updated automatically if new files are uploaded or files change.

## Installation
To install just clone this repository on your server, place your files in /files and allow apache to write files in /files/thumbs.
After that load the directory in your browser. The first time may be a little slow since all the thumbnails have to be generated.

## Adding new ThumbnailHandlers
Place all your ThumbnailHandlers in /ThumbnailHandlers
You can use the ImageHandler as an example Handler. You don't need to worry about caching as this is done by the parent class ThumbnailHandler.