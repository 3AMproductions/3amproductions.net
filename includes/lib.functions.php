<?php

function br2nl($text){return  preg_replace('/<br\\s*?\/??>/i', '', $text);}

function htmlchars($data){
 	if(is_null($data)) return NULL;
 	elseif(is_array($data)) return array_map("htmlchars",$data);
	else return (nl2br(htmlentities($data,ENT_QUOTES,'UTF-8')));}

function is_naked_day($d=9) {
    $start = date('U', mktime(-12, 0, 0, 04, $d, date('Y')));
    $end = date('U', mktime(36, 0, 0, 04, $d, date('Y')));
    $z = date('Z') * -1;
    $now = time() + $z; 
    if ( $now >= $start && $now <= $end ) {
        return true;
    }
    return false;
}
?>
