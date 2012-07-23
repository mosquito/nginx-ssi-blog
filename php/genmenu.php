<ul>
<li><a href="/">Главная</a></li>
<?php
	require_once("vars.php");
	$dirs = array();
	foreach (array_reverse(scandir($pages_root)) as $item) {
		if ($item == '.' or $item == '..') continue;
		if (is_dir($pages_root.'/'.$item)) {
			$file = $pages_root.'/'.$item.'/title.html';
			if (file_exists($file)) {
				echo '<li><a href="/'.$item.'/">';
				readfile($file);
				echo '</a></li>'."\n";
			}
		}
	}
?>
</ul>