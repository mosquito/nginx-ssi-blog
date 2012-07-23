<?php

require_once('vars.php');

class Counter
{
    var $origin_arr;
    var $modif_arr;
    var $min_word_length = 3;
 
function explode_str_on_words($text)
{
    $search = array ("'ё'",
                     "'<script[^>]*?>.*?</script>'si",  // Вырезается javascript
                     "'<[\/\!]*?[^<>]*?>'si",           // Вырезаются html-тэги
                     "'([\r\n])[\s]+'",                 // Вырезается пустое пространство
                     "'&(quot|#34);'i",                 // Замещаются html-элементы
                     "'&(amp|#38);'i",
                     "'&(lt|#60);'i",
                     "'&(gt|#62);'i",
                     "'&(nbsp|#160);'i",
                     "'&(iexcl|#161);'i",
                     "'&(cent|#162);'i",
                     "'&(pound|#163);'i",
                     "'&(copy|#169);'i",
                     "'&#(\d+);'e");
    $replace = array ("е",
                      " ",
                      " ",
                      "\\1 ",
                      "\" ",
                      " ",
                      " ",
                      " ",
                      " ",
                      chr(161),
                      chr(162),
                      chr(163),
                      chr(169),
                      "chr(\\1)");
    $text = preg_replace ($search, $replace, $text);
    $del_symbols = array(",", ".", ";", ":", "\"", "#", "\$", "%", "^",
                         "!", "@", "`", "~", "*", "-", "=", "+", "\\",
                         "|", "/", ">", "<", "(", ")", "&", "?", "¹", "\t",
                         "\r", "\n", "{","}","[","]", "'", "“", "”", "•",
                         "как", "для", "что", "или", "это", "этих",
                         "всех", "вас", "они", "оно", "еще", "когда",
                         "где", "эта", "лишь", "уже", "вам", "нет",
                         "если", "надо", "все", "так", "его", "чем",
                         "при", "даже", "мне", "есть", "раз", "два", ' не ',
                         "0", "1", "2", "3", "4", "5", "6", "7", "8", "9"
                         );
    $text = str_replace($del_symbols, array(" "), $text);
    $text = ereg_replace("( +)", " ", $text);
    $this->origin_arr = explode(" ", trim($text));
    return $this->origin_arr;
}
 
function count_words()
{
    $tmp_arr = array();
    foreach ($this->origin_arr as $val)
    {
        if (strlen($val)>=$this->min_word_length)
        {
            $val = strtolower($val);
            if (array_key_exists($val, $tmp_arr))
            {
                $tmp_arr[$val]++;
            }
            else
            {
                $tmp_arr[$val] = 1;
            }
        }
    }
    arsort ($tmp_arr);
    $this->modif_arr = $tmp_arr;
}
 
function get_keywords($text)
{
    $this->explode_str_on_words($text);
    $this->count_words();
    $arr = array_slice($this->modif_arr, 0, 10);
    $str = "";
    foreach ($arr as $key=>$val)
    {
       $str .= $key . ", ";
    }
    return trim(substr($str, 0, strlen($str)-2));
}
}

$page = $site_root.'/'.$_GET['page'];
#$page = $pages_root.'/2012-02-01';
$page_cont_f = $page.'/content.html';
$page_title_f = $page.'/title.html';

if (is_file($page_cont_f) and is_file($page_title_f)){
	$tc = fread(fopen($page_title_f,'r') ,filesize($page_title_f));
	$fdate = date("l, d-M-y H:i:s T", filemtime($page_cont_f));
	echo "\t\t".'<META HTTP-EQUIV="Expires" content="'.$fdate.'">'."\n";
	echo "\t\t".'<meta name="subject" content="'.$tc.'" />'."\n";

	$artc = (preg_split("/\s+/", $tc));
	$c = "";
	$mc = "";
	foreach ($artc as $v) {
		$mc .= $v.', ';
	}

	$c .= fread(fopen($page_cont_f,'r'), filesize($page_cont_f));
	$word_counter = new Counter();
	$mc .= $word_counter->get_keywords(substr($c, 0, 500000000));
	echo "\t\t".'<meta name="keywords" content="'.$mc.'" />'."\n";
}
?>
		<meta name="resource-type" content="document" />
		<meta name="robots" content="All" />
		<meta name="document-state" content="Dynamic" />
		<meta name="revisit" content="14" />
		<meta http-equiv="Content-Language" content="ru">
