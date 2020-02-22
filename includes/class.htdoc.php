<?php
require_once('class.jslink.php');
require_once('class.alternatestyles.php');

class HTDoc {
	var $_IE;
	var $charset, $lang, $media_type, $page_title, $base_title, $title_separator, $domain, $author, 
	$description, $keywords, $category, $copyright, $org, $xmlns, $profile, $style, $script, $extra, $meta;

	var $media = array (
		'HTML' => 'text/html', 
		'XHTML' => 'application/xhtml+xml'
	);

	/**********************************************************************************************/
	/**********************************************************************************************/
	function __construct($lang = 'en-US', $char = 'utf-8', $org = null, $domain = null, $base_title = null, $author = null, $page_title = null, $description = null, $keywords = null, $category = null, $title_separator =  ' ||| ')
	{
	 	$this->_IE = !stristr($_SERVER["HTTP_ACCEPT"], "application/xhtml+xml");
		$this->lang = $lang;
		$this->charset = $char;
		$this->org = $org;
		$this->domain = $domain;
		$this->base_title = $base_title;
		$this->author = $author;
		$this->page_title = $page_title;
		$this->description = $description;
		$this->keywords = $keywords;
		$this->category = $category;
		$this->title_separator = $title_separator;
		$this->xmlns = array();
		$this->profile = array();
		$this->meta = array();
		$this->style = new AlternateStyles();
		$this->script = new JSLink();
		$this->script->set_dir('scripts/');
		$this->script->set_relrootdir('/scripts/');
		$this->script->set_indicator('php-include');
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
		$this->extra .= $x;
	}
	
	/**********************************************************************************************/
	/**********************************************************************************************/
	function add_meta($m, $next=null, $prev=null){
		// fancy pants
		$y = date('Y');
		$this->copyright = '&#169; ' . implode('-', array_reverse(array ($y --, $y)));
		$this->copyright = implode(', ', array ($this->copyright, $this->author, $this->domain, 'All Rights Reserved'));
		$mod_date1 = date('c',filemtime($_SERVER['SCRIPT_FILENAME']));
		$mod_date2 = date('l, F jS, Y g:i A T',filemtime($_SERVER['SCRIPT_FILENAME']));
		$mod_date3 = date('D, j M Y H:i:s T',filemtime($_SERVER['SCRIPT_FILENAME']));
		$uri = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
		
		$nav = array(
			'index' => array('href'=>'index', 'title'=>'go to our homepage'),
			'approach' => array('href'=>'approach', 'title'=>'follow our web development procedure'),
			'about' => array('href'=>'about', 'title'=>'learn more about 3AM'),
			'portfolio' => array('href'=>'portfolio', 'title'=>'see some of our previous work'),
			'contact' => array('href'=>'contact', 'title'=>'get in touch with us'),
			'gilbert' => array('href'=>'gilbert', 'title'=>'see more about Gilbert'),
			'jason' => array('href'=>'jason', 'title'=>'see more about Jason'),
			'help' => array('href'=>'help', 'title'=>'see more about thesite')
		);

		$_META = array(
			'main' =>
				'<!-- Standard HTML Metadata -->'."\n\t".
				'<meta http-equiv="Content-Type" content="'.$this->media_type.'; charset='.$this->charset.'" />'."\n\t".
				'<meta http-equiv="Content-Language" content="'.$this->lang.'" scheme="RFC3066" />'."\n\t".
				'<meta http-equiv="Vary" content="Accept" />'."\n\t".
				'<meta http-equiv="Vary" content="Content-Language" />'."\n\t".
				'<meta http-equiv="Vary" content="Content-Type" />'."\n\t".
				'<meta name="Resource-Type" content="Text" scheme="DCMIType" />'."\n\t".
				'<meta name="Description" content="'.$this->description.'" />'."\n\t".
				'<meta name="Keywords" content="'.$this->keywords.'" />'."\n\t".
				'<meta name="Category" content="'.$this->category.'" />'."\n\t".
				'<meta name="Distribution" content="Global" />'."\n\t".
				'<meta name="Rating" content="General" />'."\n\t".
				'<meta name="Robots" content="index,follow" />'."\n\t".
				'<meta name="Author" content="'.$this->author.'" />'."\n\t".
				'<meta name="Organization" content="'.$this->org.'" />'."\n\t".
				'<meta name="Copyright" content="'.$this->copyright.'" />'."\n\t".
				'<meta name="Date" content="'.$mod_date1.'" scheme="W3CDTF" />'."\n\t".
				'<meta name="Updated" content="'.$mod_date2.'" scheme="W3CDTF" />'."\n\t",
			'dc' =>
				'<!-- Dublin Core Metadata - http://dublincore.org/documents/1998/09/dces/# -->'."\n\t".
				'<link type="application/rdf+xml" rel="schema.dc" title="Dublin Core Meta Data Schema" href="http://purl.org/dc/elements/1.1/" />'."\n\t".
				'<meta name="dc.title" content="'.$this->page_title.'" />'."\n\t".
				'<meta name="dc.creator" content="'.$this->author.'" />'."\n\t".
				'<meta name="dc.description" content="'.$this->description.'" />'."\n\t".
				'<meta name="dc.subject" content="'.$this->keywords.'" />'."\n\t".
				'<meta name="dc.publisher" content="'.$this->org.'" />'."\n\t".
				'<meta name="dc.contributors" content="'.$this->author.'" />'."\n\t".
				'<meta name="dc.date" content="'.$mod_date1.'" scheme="W3CDTF" />'."\n\t".
				'<meta name="dc.type" content="Text" scheme="DCMIType" />'."\n\t".
				'<meta name="dc.format" content="'.$this->media_type.'" scheme="IMT" />'."\n\t".
				'<meta name="dc.identifier" content="'.$uri.'" scheme="URI" />'."\n\t".
//				'<!-- <meta name="dc.source" content="" scheme="URI" /> -->'."\n\t".
				'<meta name="dc.language" content="'.$this->lang.'" scheme="RFC3066" />'."\n\t".
//				'<!-- <meta name="dc.relation" content="URI" /> -->'."\n\t".
				'<meta name="dc.coverage" content="Columbus, US-OH" />'."\n\t".
				'<meta name="dc.rights" content="'.$this->copyright.'" />'."\n\t",
			'dmoz' =>
				'<!-- DMOZ Directory - http://dmoz.org/ -->'."\n\t".
  				'<meta name="dmoz.id" content="'.$this->category.'" />'."\n\t",
			'geo' =>
				'<!-- GeoURL - http://geourl.org -->'."\n\t".
				'<link type="application/rdf+xml" rel="schema.geo meta" title="Geo Meta Data Schema" href="http://www.w3.org/2003/01/geo/wgs84_pos#" />'."\n\t".
				'<meta name="geo.position" content="39.9972;-83.048" scheme="GEO" />'."\n\t".
				'<meta name="geo.placename" content="1591 Presidential Dr, Apt B1, Columbus, OH 43212" scheme="GEO" />'."\n\t".
				'<meta name="geo.region" content="US-OH" scheme="GEO" />'."\n\t".
				'<meta name="geo.country" content="US" scheme="ISO3166" />'."\n\t",
			'tgn' =>
				'<!-- Getty Thesaraus of Geographical Names - http://www.getty.edu/research/conducting_research/vocabularies/tgn -->'."\n\t".
				'<meta name="tgn.id" content="7013645" scheme="TGN" />'."\n\t".
				'<meta name="tgn.name" content="Columbus" scheme="TGN" />'."\n\t".
				'<meta name="tgn.nation" content="United States" scheme="TGN" />'."\n\t",
			'icbm' =>
				'<!-- - http://geourl.org -->'."\n\t".
				'<meta name="ICBM" content="39.997202, -83.048000" scheme="ICBM" />'."\n\t",
			'icra' =>
				'<!-- Internet Content Rating Association - http://www.icra.org -->'."\n\t".
				'<link type="application/rdf+xml" rel="meta" title="ICRA labels" href="/xml/labels.rdf" />'."\n\t",
			'foaf' =>
				'<!-- Friend Of A Friend - http://www.foaf-project.org -->'."\n\t".
				'<link rel="meta" type="application/rdf+xml" title="FOAF" href="/xml/foaf.rdf" />'."\n\t",
			'cc' =>
				'<!-- Creative Commons Licensing - http://creativecommons.org -->'."\n\t".
//				'<link type="application/rdf+xml" rel="meta license cc-license" title="Creative Commons License" href="http://creativecommons.org/licenses/by-nc-sa/2.5/rdf" />'."\n\t".
				'<link type="text/html" rel="meta license cc-license" title="Creative Commons License" href="http://creativecommons.org/licenses/by-nc-sa/2.5/" />'."\n\t",
			'xmdp' =>
				'<!-- Xhtml Meta Data Profiles - http://gmpg.org/xmdp -->'."\n\t".
				'<link type="'.$this->media_type.'" rel="alternate meta" title="XMDP: XHTML Metadata Profile" href="/xmdp" />'."\n\t",
			'favicon' =>
				'<!-- Favicon -->'."\n\t".
				'<link type="image/x-icon" rel="shortcut icon" href="/images/favicon.ico" />'."\n\t".
				'<link id="logo" class="logo" type="image/gif" rel="icon" href="/images/favicon.gif" />'."\n\t",
			'nav' =>
				'<!-- Site Navigation Links -->'."\n\t".
				'<link type="'.$this->media_type.'" rel="home" title="Home" href="/" />'."\n\t".
				'<link type="'.$this->media_type.'" rel="about" title="About" href="/about" />'."\n\t".
				'<link type="'.$this->media_type.'" rel="contact" title="Contact" href="/contact" />'."\n\t".
//				'<!-- <link type="'.$this->media_type.'" rel="search" title="Search" href="/search" /> -->'."\n\t".
				'<link type="'.$this->media_type.'" rel="sitemap" title="Site Map" href="/help" />'."\n\t".
				'<link type="'.$this->media_type.'" rel="help" title="Help" href="/help" />'."\n\t".
				'<link type="'.$this->media_type.'" rel="copyright" title="Copyright Information" href="/help" />'."\n\t".
				(!is_null($next)? '<link type="'.$this->media_type.'" rel="next" title="'.$nav[$next]['title'].'" href="/'.$nav[$next]['href'].'" />'."\n\t" : '').
				(!is_null($prev)? '<link type="'.$this->media_type.'" rel="prev" title="'.$nav[$prev]['title'].'" href="/'.$nav[$prev]['href'].'" />'."\n\t" : '')
				,
			'openid' =>
				'<!-- OpenID - http://openid.net -->'."\n\t".
  				'<link rel="openid.server" href="http://www.myopenid.com/server" />'."\n\t".
				'<link rel="openid.delegate" href="http://3am.myopenid.com/" />'."\n\t".
				'<meta http-equiv="X-XRDS-Location" content="http://3am.myopenid.com/xrds" />'."\n\t",
			'openid-jason' =>
				'<!-- OpenID delegation for Jason -->'."\n\t".
				'<link rel="openid.server" href="http://www.myopenid.com/server" />'."\n\t".
				'<link rel="openid.delegate" href="http://jason.karns.name" />'."\n\t",
			'openid-gilbert' =>
				'<!-- OpenID delegation for Gilbert -->'."\n\t".
				'<link rel="openid.server" href="http://www.myopenid.com/server" />'."\n\t".
				'<link rel="openid.delegate" href="http://renegadelatino.myopenid.com/" />'."\n\t".
				'<meta http-equiv="X-XRDS-Location" content="http://renegadelatino.myopenid.com/xrds" />'."\n\t",
			'microid' =>
				'<!-- MicroID - http://microid.org -->'."\n\t".
				// 3am@3amproductions.net, http://3amproductions.net
  				'<meta name="microid" content="mailto+http:sha1:3d8dd38eae9553ef9667d67380595d144a980adc" />'."\n\t",
			'atom' =>
				'<!-- Atom Portfolio Feed - http://intertwingly.net/moin-1.2.1/wiki/cgi-bin/moin.cgi/FrontPage -->'."\n\t".
				'<link rel="alternate" type="application/atom+xml" title="3AM Productions: Portfolio (Atom 1.0)" href="/atom" />'."\n\t",
			'errorlogfeed' =>
				'<!-- Atom Error Log Feed - http://intertwingly.net/moin-1.2.1/wiki/cgi-bin/moin.cgi/FrontPage -->'."\n\t".
				'<link rel="alternate" type="application/atom+xml" title="3AM Productions: Error Log" href="/error/feed" />'."\n\t",
			'rss' =>
				'<!-- RSS Portfolio Feed - http://cyber.law.harvard.edu/rss/rss.html -->'."\n\t".
				'<link rel="alternate" type="application/rss+xml" title="3AM Productions: Portfolio (RSS 2.0)" href="/rss" />'."\n\t",
			'grddl' =>
				'<!-- Gleaning Resource Descriptions from Dialects of Languages - http://www.w3.org/2003/g/data-view-->'."\n\t".
				'<link rel="transformation" href="http://www.w3.org/2003/12/rdf-in-xhtml-xslts/grokGeoURL.xsl" title="Extract GeoURL data as RDF" type="application/xslt+xml" />'."\n\t".
				'<link rel="transformation" href="http://www.w3.org/2000/06/dc-extract/dc-extract.xsl" title="Extract Dublin Core Metadata as RDF" type="application/xslt+xml" />'."\n\t".
				'<link rel="transformation" href="http://www.w3.org/2003/12/rdf-in-xhtml-xslts/grokCC.xsl" title="Extract Creative Commons License data as RDF" type="application/xslt+xml" />'."\n\t".
				'<link rel="transformation" href="http://www.w3.org/2003/12/rdf-in-xhtml-xslts/grokFOAF.xsl" title="Extract FOAF data as RDF" type="application/xslt+xml" />'."\n\t".
				'<link rel="transformation" href="http://www.w3.org/2006/vcard/hcard2rdf.xsl" title="Extract hCard data as RDF" type="application/xslt+xml" />'."\n\t".
				'<link rel="transformation" href="http://www.w3.org/2002/12/cal/glean-hcal.xsl" title="Extract hCalendar data as RDF" type="application/xslt+xml" />'."\n\t",
			'sitemap' =>
				'<!-- sitemap.xml and ror.xml - http://sitemap.org - http://rorweb.com -->'."\n\t".
				'<link rel="sitemap" type="application/xml" title="Sitemap.xml" href="/sitemap.xml" />'."\n\t".
				'<link rel="sitemap" type="application/rss+xml" title="ROR Sitemap" href="/ror.xml" />'."\n\t"
  		);

		if(is_array($m)){
			$this->meta = array_merge($this->meta, array_intersect_key($_META, array_flip($m)));
		} else $this->meta[] = $_META[$m];
	}
	
	/**********************************************************************************************/
	/**********************************************************************************************/
	function head($css = null, $js = null) {
		if($this->page_title) $this->page_title = $this->base_title . $this->title_separator . $this->page_title;
		else $this->page_title = $this->base_title;

		echo "\n".'<head profile="'.implode(" ", $this->profile).'">'."\n\t";
		echo "<title>$this->page_title</title>\n\t";
		echo implode("", $this->meta);

		// print css
		$this->style->getPreferredStyles();
		$this->style->drop();

		// print javascript
 		echo $this->script->deliver();

        // print extra
		echo $this->extra;
		
		// end head
		print "\n</head>\n";
	} // head() 

}
?>
