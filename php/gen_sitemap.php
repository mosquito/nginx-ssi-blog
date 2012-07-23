<?php
	require_once("vars.php");
	$dirs = array();
	foreach (array_reverse(scandir($pages_root)) as $item) {
		if ($item == '.' or $item == '..') continue;
		if (is_dir($pages_root.'/'.$item)) {
			$file = $pages_root.'/'.$item.'/title.html';
			$file_contain = $pages_root.'/'.$item.'/content.html';
			if (file_exists($file_contain)) {
				echo "<url>\n";
				echo "\t<loc>"."<!--# echo var='scheme' -->"."://".$_SERVER['HTTP_HOST'].'/'.$item."/</loc>\n";
				echo "\t<lastmod>".date ("Y-m-d\TH:i:sP", filemtime($file_contain))."</lastmod>\n";
				echo "\t<changefreq>weekly</changefreq>\n";
				echo "\t<priority>1.0</priority>\n";
				echo "</url>\n";
			}
		}
	}
?>
