<?php 

//error_reporting(E_ALL);      
//ini_set('display_errors', 1);

require "simple_html_dom.php";

$lolspeak = [];
$latin = [];

 // gets rid of links
function remove_link($element) {
	       if ($element->tag=='a')
	                $element->outertext = '';        
}

function remove_span($element) {
	       if ($element->tag=='span')
	                $element->outertext = '';        
}

function remove_tags($str){
	$str=str_replace('"', '',$str);
	$str=str_replace('<dd>', '',$str);
	$str=str_replace('</dd>', '',$str);
	$str=str_replace('<dl>', '',$str);
	$str=str_replace('</dl>', '',$str);
	$str=str_replace('<pre>', '',$str);
	$str=str_replace('</pre>', '',$str);
}

// grabs the innertext of elements and adds the to an array

//lolspeak
for ($i=1; $i <= 16; $i++) {
	$lolHTML = file_get_html('http://www.lolcatbible.com/index.php?title=Mark_'.$i); 	
	$lolHTML->set_callback('remove_link');
	remove_tags($lolHTML);
	foreach ($lolHTML->find('span[id]') as $s) {
		$sentence = $s->innertext;
		array_push($lolspeak, $sentence);
	}	
};
file_put_contents("lolspeak.txt", $lolspeak);

//latin
$lorenHTML = file_get_html('http://la.wikisource.org/wiki/De_finibus_bonorum_et_malorum/Liber_Primus');
$lorenHTML->set_callback('remove_link');	
$lorenHTML->set_callback('remove_span');
remove_tags($lorenHTML);
foreach ($lorenHTML->find('p') as $p) {
	$paragraph = $p->innertext;
	$paragraph = explode(']', $paragraph);
	array_push($latin, $paragraph[1]);
}

file_put_contents("latin.txt", $latin);
 








	
