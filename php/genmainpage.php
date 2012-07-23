<?php
	require_once("vars.php");
	$dirs = array();
	foreach (array_reverse(scandir($pages_root)) as $item) {
		if ($item == '.' or $item == '..') continue;
		if (is_dir($pages_root.'/'.$item)) {
			$file = $pages_root.'/'.$item.'/title.html';
			$file_contain = $pages_root.'/'.$item.'/content.html';
			if (file_exists($file) and file_exists($file_contain)) {
				echo '<div class="content"><span class="date">'.$item.'</date> <a href="/'.$item.'/">';
				readfile($file);
				echo '</a>';
				$content = fopen($file_contain, 'r');
				echo '<p class="page_contain">';
				$c = fread($content, 2048);
				try {
					$cc = explode('<!-- CUT -->', $c);
					echo $cc[0] ;
				} catch (Exception $e) {
					echo $c;
				}
				echo '</p>';
				echo '</div>'."\n";
			}
		}
	}
?>
