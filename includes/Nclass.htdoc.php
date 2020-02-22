<?php
require_once('class.jslink.php');
require_once('class.alternatestyles.php');

class HTDoc {
	var $_IE;
    var $_META, $META_FLAGS, $_NAV;
	var $charset, $lang, $media_type, $page_title, $base_title, $title_separator, 
	$copyright, $xmlns, $profile, $style, $script, $extra, $meta;

	var $media = array (
		'HTML' => 'text/html',
		'XHTML' => 'application/xhtml+xml'
	);

	/**********************************************************************************************/
	/**********************************************************************************************/
	function __construct($_META = null, $_NAV = null, $META_DEFAULTS = null, $META_FLAGS = null)
	{
	 	$this->_IE = !stristr($_SERVER["HTTP_ACCEPT"], "application/xhtml+xml");
        $this->_NAV = !is_null($_NAV) ? $_NAV : array();
        $this->_META = !is_null($_META) ? $_META : array();
	 	$this->META_FLAGS = !is_null($META_FLAGS) ? $META_FLAGS : array(
                'media_type' => '/==MEDIA_TYPE==/',
                'charset' => '/==CHARSET==/',
                'lang' => '/==LANG==/',
                'copyright' => '/==COPYRIGHT==/',
                'created' => '/==CREATED==/',
                'updated' => '/==UPDATED==/',
                'title' => '/==TITLE==/',
                'uri' => '/==URI==/'
            );
		$this->lang = (!is_null($META_DEFAULTS) and array_key_exists('lang',$META_DEFAULTS) and $META_DEFAULTS['lang'] != '') ? $META_DEFAULTS['lang'] : 'en-US';
		$this->charset = (!is_null($META_DEFAULTS) and array_key_exists('charset',$META_DEFAULTS) and $META_DEFAULTS['charset'] != '') ? $META_DEFAULTS['charset'] : 'utf-8';
		$this->base_title = (!is_null($META_DEFAULTS) and array_key_exists('base_title',$META_DEFAULTS) and $META_DEFAULTS['base_title'] != '') ? $META_DEFAULTS['base_title'] : '';
		$this->page_title = (!is_null($META_DEFAULTS) and array_key_exists('page_title',$META_DEFAULTS) and $META_DEFAULTS['page_title'] != '') ? $META_DEFAULTS['page_title'] : '';
		$this->title_separator = (!is_null($META_DEFAULTS) and array_key_exists('title_separator',$META_DEFAULTS) and $META_DEFAULTS['title_separator'] != '') ? $META_DEFAULTS['title_separator'] : ' | ';
		$this->xmlns = array();
		$this->profile = array();
		$this->meta = array();
        $this->extra = array();
		$this->style = new AlternateStyles();
		$this->script = new JSLink();
		$this->script->set_dir('scripts/');
		$this->script->set_relrootdir('/scripts/');
		$this->script->set_indicator('php-include');
        HTDoc::conditional_get();
	}
	
    /**********************************************************************************************/
    /* Props to Simon Willison [http://simonwillison.net/2003/Apr/23/conditionalGet/]             */
    /**********************************************************************************************/
    function conditional_get($timestamp = null) {
    // A PHP implementation of conditional get, see 
    //   http://fishbowl.pastiche.org/archives/001132.html
    if(is_null($timestamp)) $timestamp = time();
//    $last_modified = substr(date('r', $timestamp), 0, -5).'GMT';
    $last_modified = gmdate('D, d M Y H:i:s \G\M\T', $timestamp);
    $etag = '"'.md5($last_modified).'"';

    // Send the headers
    header("Last-Modified: $last_modified");
    header("ETag: $etag");

    // See if the client has provided the required headers
    $if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ?
        stripslashes($_SERVER['HTTP_IF_MODIFIED_SINCE']) :
        false;
    $if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ?
        stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) : 
        false;
    if (!$if_modified_since && !$if_none_match)
        return;

    // At least one of the headers is there - check them
    if ($if_none_match && $if_none_match != $etag)
        return; // etag is there but doesn't match
    if ($if_modified_since && $if_modified_since != $last_modified)
        return; // if-modified-since is there but doesn't match
    // Nothing has changed since their last request - serve a 304 and exit
    header('HTTP/1.0 304 Not Modified');
    exit;
    }

    /**********************************************************************************************/
    /**********************************************************************************************/
	function add_namespace($prefix, $uri){
		$this->xmlns[] = array(prefix=>$prefix, uri=>$uri);
	}
	
	/**********************************************************************************************/
	/* doctype() -- DOCTYPE HTML 4.01 and XHTML 1.0/1.1 Transitional, Frameset and Strict
	                  also peforms content-type negotiation
	(c) Copyright 2004-2005, Douglas W. Clifton, all rights reserved.
	    for more copyright information visit the following URI:
	    http://loadaveragezero.com/info/copyright.php */
	/**********************************************************************************************/
	function doctype($doc = 'xhtml', $type = 'strict', $ver = '1.1') {
		$doc = strtoupper($doc);
		$type = strtolower($type);

		$avail = 'PUBLIC'; // or SYSTEM, but we're not going there yet

		// begin FPI
		$ISO = '-'; // W3C is not ISO registered [or IETF for that matter]
		$OID = 'W3C'; // unique owner ID
		$PTC = 'DTD'; // the public text class

		// as far as I know the PCL is always English
		$PCL = 'EN';
		$xlang = 'en'; // this you may want to vary if you're in different locale

		// DTDs are all under the Technical Reports (TR) branch @ W3C
		$URI = 'http://www.w3.org/TR/';

		$doc_top = '<html'; // what comes after the DOCTYPE of course

		if ($doc == 'HTML') {

			$top = $doc;
			$this->media_type = $this->media[$doc];

			$PTD = $doc.' 4.01'; // we're only supporting HTML 4.01 here

			switch ($type) {
				case 'frameset' :
					$PTD .= ' '.ucfirst($type);
					$URI .= 'html4/frameset.dtd';
					break;
				case 'transitional' :
					$PTD .= ' '.ucfirst($type);
					$URI .= 'html4/loose.dtd';
					break;
				case 'strict' :
				default :
					$URI .= 'html4/strict.dtd';
			}
			$doc_top .= ' lang="'.$this->lang.'">'; // no namespaces here
		} else {

			// must be xhtml then, but catch typos
			if ($doc != 'XHTML')
				$doc = 'XHTML';

			$top = 'html'; // remember XML is lowercase
			$doc_top .= ' xmlns="http://www.w3.org/1999/xhtml" xml:lang="'.$this->lang.'"';
			
			foreach($this->xmlns as $ns){
				$doc_top .= ' xmlns:' . $ns[prefix] . '="' . $ns[uri] . '"';
			}

			// return the correct media type header for this document,
			// but we should probably make sure the browser groks XML!
			// the W3C validator does not send the correct Accept header for this family of documents, sigh
			if (stristr($_SERVER['HTTP_USER_AGENT'], 'W3C_Validator'))
				$this->media_type = $this->media['XHTML'];
			else
				$this->media_type = (stristr($_SERVER['HTTP_ACCEPT'], $this->media['XHTML'])) ? $this->media['XHTML'] : $this->media['HTML'];

			// do NOT send XHTML 1.1 to browsers that don't accept application/xhtml+xml
			// see: labs/PHP/DOCTYPE.php#bug-fix for details and a link to the W3C XHTML
			// NOTES on this topic
			if ($this->media_type == $this->media['HTML'] and $ver == '1.1')
				$ver = '1.0';
			if ($ver == '1.1') {
				$PTD = implode(' ', array ($doc, $ver));
				$URI .= 'xhtml11/DTD/xhtml11.dtd';
			} else {
				$PTD = implode(' ', array ($doc, '1.0', ucfirst($type)));
				$URI .= 'xhtml1/DTD/xhtml1-'.$type.'.dtd';
				// for backwards compatibilty
				$doc_top .= ' lang="'.$this->lang.'"';
			}
			$doc_top .= '>'; // close root XHTML tag

			// send HTTP headers
			header('Content-Type: '.$this->media_type.'; charset='.$this->charset);
			header('Content-Language: '.$this->lang);
			header('Vary: Accept,Content-Type,Content-Language');


			// send the XML declaration before the DOCTYPE, but this
			// will put IE into quirks mode which we don't want
			if (!$this->_IE)
				print '<?xml version="1.0" encoding="'.$this->charset.'"?>'."\n";
		}

		$FPI = implode('//', array ($ISO, $OID, $PTC.' '.$PTD, $PCL));
		echo "<!DOCTYPE " . $top . " " . $avail . " \"" . $FPI . "\" \"" . $URI . "\">\n";
		echo $doc_top;
	} // doctype()

	/**********************************************************************************************/
	/**********************************************************************************************/
	function add_style($path,$media='',$title='',$alternate=false,$condcom=''){
		$m = explode(',',$media);
		if(!function_exists('is_naked_day') or !is_naked_day() or (!in_array('all',$m) and !in_array('screen',$m) and !in_array('projection',$m)))
		$this->style->add($path,$media,$title,$alternate,$condcom);
	}

	/**********************************************************************************************/
	/**********************************************************************************************/
	function add_script($js){
	  $this->script->request($js);
	}

	/**********************************************************************************************/
	/**********************************************************************************************/
	function add_profile($url){
		$_PROFILES = array(
			'grddl' => 'http://www.w3.org/2003/g/data-view',
			'hcard' => 'http://microformats.org/wiki/hcard-profile',
			'hcalendar' => 'http://microformats.org/wiki/hcalendar-profile',
			'hatom' => 'http://microformats.org/wiki/hatom#XMDP_Profile',
			'xoxo' => 'http://microformats.org/wiki/xoxo#The_XOXO_Profile',
			'geo' => 'http://geotags.com',//geo is part of hcard
			'xfn' => 'http://gmpg.org/xfn/11',
			'rel-license' => 'http://microformats.org/wiki/rel-license#XMDP_profile',
			'rel-nofollow' => 'http://microformats.org/wiki/rel-nofollow#XMDP_profile',
			'rel-tag' => 'http://microformats.org/wiki/rel-tag',
			'vote-links' => 'http://microformats.org/wiki/vote-links',
			'xmdp' => 'http://microformats.org/wiki/xmdp-profile',
			'3am-xmdp' => 'http://3amproductions.net/xmdp'
			);

		if(is_array($url)){
			$this->profile = array_merge($this->profile, array_intersect_key($_PROFILES, array_flip($url)));
		} else $this->profile[] = $_PROFILES[$url];
	}
	
	/**********************************************************************************************/
	/**********************************************************************************************/
	function add_extra($x){
		if(is_array($x))
            $this->extra = array_merge($this->extra,$x);
        else
            $this->extra[] = $x;
	}
	
	/**********************************************************************************************/
	/**********************************************************************************************/
	function add_meta($m, $next=null, $prev=null){
		// fancy pants
		$y = date('Y');
		$copyright = implode('-', array_reverse(array ($y --, $y)));
		$mod_date1 = date('c',filemtime($_SERVER['SCRIPT_FILENAME']));
		$mod_date2 = date('l, F jS, Y g:i A T',filemtime($_SERVER['SCRIPT_FILENAME']));
		$mod_date3 = date('D, j M Y H:i:s T',filemtime($_SERVER['SCRIPT_FILENAME']));
		$uri = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
		
        if(!is_null($next))
            $this->_META['nav'][] = '<link type="==MEDIA_TYPE==" rel="next" title="'.$this->_NAV[$next]['title'].'" href="/'.$this->_NAV[$next]['href'].'" />'; 
        if(!is_null($prev))
            $this->_META['nav'][] = '<link type="==MEDIA_TYPE==" rel="prev" title="'.$this->_NAV[$prev]['title'].'" href="/'.$this->_NAV[$prev]['href'].'" />';

		if(is_array($m)){
			$meta = array_intersect_key($this->_META, array_flip($m));
            foreach($meta as $k => $v){
                $meta[$k] = implode("\n\t",$v);
            }
            $meta = implode("\n\t",$meta);
		}
        else {
            if(!array_key_exists($m, $this->_META)) return;
            $meta = implode("\n\t",$this->_META[$m]);
        }

        $flags = array(
            'media_type' => $this->media_type,
            'charset' => $this->charset,
            'lang' => $this->lang,
            'copyright' => $copyright,
            'created' => $mod_date1,
            'updated' => $mod_date2,
            'title' => '==TITLE==',
            'uri' => '==URI==');
        ksort($this->META_FLAGS);
        ksort($flags);
        $this->meta[] = preg_replace($this->META_FLAGS,$flags,$meta);
	}
	
	/**********************************************************************************************/
	/**********************************************************************************************/
	function head($atts = null) {
		if($this->page_title) $this->page_title = $this->base_title . $this->title_separator . $this->page_title;
		else $this->page_title = $this->base_title;

        $profile = (count($this->profile) > 0) ? ' profile="'.implode(" ", $this->profile).'"' : '';
        if(is_array($atts)){
            foreach($atts as $att=>$val){
                $add_atts .= ' '.$att.'="'.$val.'"';
            }
        }
		echo "\n".'<head'.$add_atts.$profile.'>'."\n\t";
		echo "<title>$this->page_title</title>\n\t";
		echo implode("\n\t", $this->meta)."\n\t";

		// print css
        echo "<!-- CSS Stylesheets -->\n\t";
        
		$this->style->getPreferredStyles();
		$this->style->drop();

		// print javascript
        echo "<!-- JavaScript -->\n\t";
 		echo $this->script->deliver();

        // print extra
		echo implode("\n\t", $this->extra);
		
		// end head
		print "\n</head>\n";
	} // head()
}
?>
