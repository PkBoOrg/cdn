<?php

define('BASE_URL', 'https://cdn.hey.onylab.com/image/product/promo/');

function endsWith( $haystack, $needle ) {
    $length = strlen( $needle );
    if( !$length ) {
        return true;
    }
    return substr( $haystack, -$length ) === $needle;
}

$content = [];
foreach (new DirectoryIterator('./') as $fileInfo) {
    if($fileInfo->isDot()) {
		continue;
	}
	
	if (!endsWith($fileInfo->getFilename(), 'jpg')) {
		continue;
	}
	
    $content[] = BASE_URL . $fileInfo->getFilename();
	echo $fileInfo->getFilename() . PHP_EOL;
}

file_put_contents('list.json', json_encode($content));
