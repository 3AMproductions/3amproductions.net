<?php
require_once('../config.inc');
require_once('Zend/Feed.php');
require_once('class.clf_log.php');

$item = false;
$errors = array();
$tags = array();
$nottags = array("200");

if(isset($_SERVER['PATH_INFO'])){
	$path = explode("/",$_SERVER['PATH_INFO']);
    
    if(($tmp = array_search("tags",$path)) !== false){
        $tmp = explode(",", $path[++$tmp]);
        foreach($tmp as $t){
            if(3 <= strlen($t) and strlen($t) <= 4) {
                if(strpos($t,"!") === false)
                    $tags[] = $t;
                else
                    $nottags[] = substr($t,1);	
            }
        }
    }
    else {
    	$item = $path[1];
    }
}

$errorlog = file("../../logs/3amproductions.net/http/error.log", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach($errorlog as $error){
//	$pattern = '/\[(.*?)\] \[(.*?)\] \[client (.*?)\] File does not exist: \/home\/pimp3am\/3amproductions.net(.*$)/';
	$pattern = '/\[(.*?)\]/';
	preg_match($pattern, $error, $matches);
	$errors[] = strtotime($matches[1]." -0700");//must add timezone offset because error log doesn't have it'
}


$CLF = new CLF_Log_Parser("../../logs/3amproductions.net/http/access.log");
if ($CLF->open()) // Make sure it opens the log file
{
	while ($line = $CLF->get_line()) { // while it can get a line
		$entry = $CLF->parse($line); // format the line

		$timestamp = strtotime($entry['date']."T".$entry['time']);

		if((($item and $item == $timestamp) or (!$item and in_array($timestamp, $errors)))){
            // skip entries per tag request
            if(isset($tags) and is_array($tags) and (count($tags) > 0) and !in_array($entry['code'],$tags)) continue;
            if(in_array($entry['code'],$nottags)) continue;
            
			$entries[] = array(
				'title'        => "http://3amproductions.net" . htmlentities($entry['request']),
				'link'         => 'http://3amproductions.net/error/log/'.$timestamp,
                'guid'         => 'http://3amproductions.net/error/feed/'.$timestamp,
				'lastUpdate'   => $timestamp,
				'description'  => "\n\t" .
					"Date:      ".$entry['date']." ".$entry['time']."\n\t".
					"File:      ".$entry['request']."\n\n\t".
					"Client:    ".$entry['ip']."\n\t".
					"Referer:   ".$entry['referer']."\n\t".
					"Useragent: ".$entry['useragent']."\n\t".
					"Method:    ".$entry['method']."\n\t".
					"Protocol:  ".$entry['protocol']."\n\t".
					"Code:      ".$entry['code']."\n\t".
					"Size:      ".$entry['size']."\n\t".
					"Username:  ".$entry['username']."\n",
                'content'      => 
                        '<dl class="entry-content description">' .
                                '<dt>Date</dt>' . '<dd><abbr class="published updated dtstart dtend" title="'.$entry['date']."T".$entry['time'].'-05:00">'.$entry['date']." ".$entry['time'].'</abbr></dd>' .
                                '<dt>File</dt>' . '<dd>'.htmlentities($entry['request']).'</dd>' .
                                '<dt>Client</dt>' . '<dd>'.$entry['ip'].'</dd>' .
                                '<dt>Referrer</dt>' . '<dd>'.$entry['referer'].'</dd>' .
                                '<dt>Useragent</dt>' . '<dd>'.$entry['useragent'].'</dd>' .
                                '<dt>Method</dt>' . '<dd>'.$entry['method'].'</dd>' .
                                '<dt>Protocol</dt>' . '<dd>'.$entry['protocol'].'</dd>' .
                                '<dt>Code</dt>' . '<dd><a href="http://3amproductions.net/error/log/tag/'.$entry['code'].'" title="See all '.$entry['code'].' errors" rel="tag">'.$entry['code'].'</a></dd>' .
                                '<dt>Size</dt>' . '<dd>'.$entry['size'].'</dd>' .
                                '<dt>Username</dt>' . '<dd>'.$entry['username'].'</dd>' .
                         '</dl>',
                'category'     => array(array('term' => $entry['code'],
                                              'label' => $entry['code'],
                                              'scheme' => 'http://3amproductions.net/error/log/tag/')));
  		}
  		if($item and $item == $timestamp) break;// if looking for single entry, break when found
	}
  $CLF->close(); // close the log file
}
else
{
  $entries[] = array(
  					'title'			=> 'Sorry cannot open log file.',
  					'link'			=> 'http://3amproductions.net/error',
  					'lastUpdate'	=> time(),
  					'description'	=> 'The log file could not be opened.',
  					'guid'			=> 'http://3amproductions.net/error');
}

$atom = array(
	'title'			=> '3AM Error Log',
	'link'			=> 'http://3amproductions.net/error/feed',
	'charset'		=> 'UTF-8',
	'author'		=> '3AM Productions',
	'email'			=> '3am@3amproductions.net',
	'description'	=> 'Feed generated from Apache error log file.',
	'entries'		=> $entries );

$feed = Zend_Feed::importArray($atom, 'atom');

if($item){
	// TODO: output as Atom Entry Document (without feed container elements)
	$feed->send();
}
else{ 
	$feed->send();
}
?>
