<?php
/**
 * Class Alternates:
 * 	This class simply re-implements array to be iteratable as referenced from a
 * 	Project or Folio. Also implements get() for direct access.
 */
class Alternates implements Iterator {
	/**
	 * @var array urls of images stored
	 * @access private
	 */
	private $pics = array();

	/**
	 * @var boolean existence of current element
	 * @access private
	 */
	private $valid = false;

	/**
	 * Constructor takes array to store.
	 * @param array arr array to store and iterate over
	 */
	function __construct($arr) {
		$this->pics = $arr;}

	/**
	* Rewind the Iterator to the first element.
	* Similar to the reset() function for arrays in PHP
	* @return void
	*/
	function rewind(){
		$this->valid = (false !== reset($this->pics));}

	/**
	* Return the current element.
	* Similar to the current() function for arrays in PHP
	* @return mixed current element from the collection
   	*/
	function current(){
		return current($this->pics);}

	/**
	* Return the identifying key of the current element.
	* Similar to the key() function for arrays in PHP
	* @return mixed either an integer or a string
	*/
	function key(){
		return key($this->pics);}

	/**
	* Move forward to next element.
	* Similar to the next() function for arrays in PHP
	* @return void
	*/
	function next(){
		$this->valid = (false !== next($this->pics));}

	/**
	* Check if there is a current element after calls to rewind() or next().
	* Used to check if we've iterated to the end of the collection
	* @return boolean FALSE if there's nothing more to iterate over
	*/
	function valid(){
		return $this->valid;}

	/**
	 * Direct access to an element via key
	 * @access public
	 * @param int x integer key of desired element
	 */
	function get($x){
		return $this->pics[$x];}
}

/**
 * Class Project:
 * 	The class stores information for one project. (array of these is stored in Folio)
 * 	Implements ArrayAccess to allow array-like access to member fields. 
 */
class Project implements ArrayAccess {
	/**
	 * @var string title of project
	 * @access private
	 */
	private $title;

	/**
	 * @var string url of project's live site on web
	 * @access private
	 */
	private $href;

	/**
	 * @var string url of project's 'clip' image
	 * @access private
	 */
	private $clip;

	/**
	 * @var Alternates array of big images (urls)
	 * @access private
	 */
	private $big;

	/**
	 * @var Alternates array of small images (urls)
	 * @access private
	 */
	private $small;

	/**
	 * @var string text description of project
	 * @access private
	 */
	private $text;

	/**
	 * Constructor initializes big and small Alternates
	 * @access public
	 */
	public function __construct(){
		$this->big = new Alternates(array());
		$this->small = new Alternates(array());}

	/**
	* Defined by ArrayAccess interface
	* Set a value given it's key e.g. $A['title'] = 'foo';
	* @param mixed key (string or integer)
	* @param mixed value
	* @return void
	*/ 
 	function offsetSet($key, $value) {
		if ( array_key_exists($key,get_object_vars($this)) ) {
		$this->{$key} = $value;}}

	/**
	* Defined by ArrayAccess interface
	* Return a value given it's key e.g. echo $A['title'];
	* @param mixed key (string or integer)
	* @return mixed value
	*/
	function offsetGet($key) {
		if ( array_key_exists($key,get_object_vars($this)) ) {
		return $this->{$key};}}

	/**
	* Defined by ArrayAccess interface
	* Unset a value by it's key e.g. unset($A['title']);
	* @param mixed key (string or integer)
	* @return void
	*/
	function offsetUnset($key) {
		if ( array_key_exists($key,get_object_vars($this)) ) {
		unset($this->{$key});}}

	/**
	* Defined by ArrayAccess interface
	* Check value exists, given it's key e.g. isset($A['title'])
	* @param mixed key (string or integer)
	* @return boolean
	*/
	function offsetExists($offset) {
		return array_key_exists($offset,get_object_vars($this));}
}

/**
 * Class Folio:
 * 	This class allows quick access to project information obtained from XML file.
 * 	XML file is loaded with load() or constructor, project text, url, title, and image
 * 	information is then available. Methods available for direct info access as well
 * 	as for returning entire html snippets.
 */
class Folio implements Iterator {

	/**
	 * Array of projects to iterate over
	 * @access private
	 */
 	private $projects = array();

	/**
	 * A switch to keep track of the end of the array
	 * @access private
	*/
	private $valid = false;

	private $xmlns = "";

   /**
   * Constructor
   * @param string file filename of valid projects xml file to use as portfolio
   */
	public function __construct($file = null) {
		if(!is_null($file))
			$this->load($file);
	}

	/**
	 * Set the XML Namespace prefix for returned elements
	 * @param string xmlns XML namespace prefix to be used
	 */
	 public function xmlns_prefix($xmlns = null) {
	 	if(is_null($xmlns)) $this->xmlns = "";
	 	else $this->xmlns = $xmlns.":";
	 }

	/**
	* Return the array "pointer" to the first element
	* PHP's reset() returns false if the array has no elements
	* @access public
	* @return void 
	*/
	public function rewind(){
		$this->valid = (false !== reset($this->projects));
	}

	/**
	* Return the current array element
	* @access public
	* @return array current project array from portfolio or FALSE if doesn't exist
	*/
	public function current(){
		return current($this->projects);
	}

	/**
	* Return the key of the current array element
	* @access public
	* @return mixed array key of current project (int or string)
	*/
	public function key(){
		return key($this->projects);
	}

	/**
	* Move forward by one
	* PHP's next() returns false if there are no more elements
	* @access public
	* @return void 
	*/
	public function next(){
		$this->valid = (false !== next($this->projects));
	}

	/**
	* Is the current element valid?
	* @access public
	* @return boolean validity of current element
	*/
	public function valid(){
		return $this->valid;
	}

	/**
	 * Load an XML portfolio file into the array of projects for data extraction.
	 * The projects array is cached so overhead of XML parsing is only done once after
	 * each time the XML file is modified.
	 * This is method is also called implicitly by passing the XML filename to the constructor.
	 * @access public
	 * @return void 
	 */
	public function load($file){
		$cachemtime = @filemtime($file.'.cache');
		$origmtime = @filemtime($file);
		if(!$origmtime) return false; 
		if(!$cachemtime or ($origmtime > $cachemtime)){
			$doc = new DOMDocument();
			$doc->load($file);
			$xpath = new DOMXPath($doc);
			$projects = $xpath->query('/portfolio/project[showcase]');
			foreach ($projects as $project) {
				$small = array();
				$big = array();
				foreach ($xpath->query('showcase/images/screenshot/thumbnail',$project) as $img){
					$small[] = $img->nodeValue;}
				foreach ($xpath->query('showcase/images/screenshot/src',$project) as $img){
					$big[] = $img->nodeValue;}
				$p = new Project();
				$p['title'] = $xpath->query('showcase/title',$project)->item(0)->nodeValue;
				$p['href'] = $xpath->query('livesite',$project)->item(0)->nodeValue;
				$p['clip'] = $xpath->query('showcase/images/feature/thumbnail',$project)->item(0)->nodeValue;
				$p['big'] = new Alternates($big);
				$p['small'] = new Alternates($small);
				$p['text'] = $xpath->query('showcase/description',$project)->item(0)->nodeValue;
				$keys[] = $xpath->query('@id',$project)->item(0)->nodeValue;
				$values[] = $p; 	
			}
			$this->projects = array_combine($keys,$values);
			$cache = serialize($this->projects);
			$cachefile = @fopen($file.'.cache','wb');
			if($cachefile) @fwrite($cachefile,$cache);
		} else {
			$cache = @file_get_contents($file.'.cache');
			if($cache) $this->projects = unserialize($cache);
			else return false;
		}
	}
	
	/**
	 * Select a project (and optionally, the big image) to remain active for other queries.
	 * @param key x key (string or int) of desired project in array
	 * @param key b key (string or int) of desired big picture in big Alternates
	 * @return boolean requested project exists
	 */
	function choose_project($x,$b=null){
		if(key_exists($x,$this->projects)){
			$this->choose_big($b);
			foreach($this as $t){
				if($this->key() == $x) break;
			}
			return true;
		}
		return false;
	}

	/**
	 * Retrieve currently active (or explicitly requested) project title.
	 * @param key x Optionally request a specific project's title.
	 * @return string project title
	 */
	function title($x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		return $this->projects[$x]['title'];
	}

	/**
	 * Retrieve currently active (or explicitly requested) project text.
	 * @param key x Optionally request a specific project's text.
	 * @return string project text
	 */
	function text($x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		return $this->projects[$x]['text'];
	}

	/**
	 * Retrieve currently active (or explicitly requested) project href.
	 * @param key x Optionally request a specific project's href.
	 * @return string project href
	 */
	function href($x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		return $this->projects[$x]['href'];
	}

	/**
	 * Retrieve currently active (or explicitly requested) project link html ('A' tag).
	 * @param key x Optionally request a specific project's link html ('A' tag).
	 * @return string project link html ('A tag')
	 */
	function anchor($x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		$a = '<'.$this->xmlns.'a href="'.$this->href($x).'" title="visit '.$this->title($x).'">'.$this->title($x).'</'.$this->xmlns.'a>';
		return $a;
	}

	/**
	 * Retrieve currently active (or explicitly requested) project clip img src.
	 * @param key x Optionally request a specific project's clip img src.
	 * @return string project clip img src
	 */
	function clip_src($x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		return $this->projects[$x]['clip'];
	}

	/**
	 * Retrieve currently active (or explicitly requested) project clip image alt.
	 * @param key x Optionally request a specific project's clip image alt text.
	 * @return string project clip image alt text
	 */
	function clip_alt($x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		return "screenshot of ".$this->title($x);
	}

	/**
	 * Retrieve currently active (or explicitly requested) project clip image title.
	 * @param key x Optionally request a specific project's clip image title.
	 * @return string project clip image title
	 */
	function clip_title($x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		return "select project: ".$this->title($x);
	}

	/**
	 * Retrieve currently active (or explicitly requested) project clip image html ('IMG' tag)
	 * @param key x Optionally request a specific project's clip image html ('IMG' tag)
	 * @return string project clip image html ('IMG' tag)
	 */
	function clip_img($x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		$img = '<'.$this->xmlns.'img src="'.$this->clip_src($x).'" alt="'.$this->clip_alt($x).'" title="'.$this->clip_title($x).'"/>';
		return $img;
	}

	/**
	 * Retrieve currently active (or explicitly requested) project clip image href.
	 * @param key x Optionally request a specific project's clip image href.
	 * @return string project clip image href
	 */
	function clip_href($x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		return '/portfolio/'.$x.'/';
//		return '/portfolio4.php?p='.$x.'';
	}

	/**
	 * Retrieve currently active (or explicitly requested) project clip as a linked image
	 * @param key x Optionally request a specific project's clip as a linked image
	 * @return string project clip as a linked image (html)
	 */
	function clip($x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		$clip = '<'.$this->xmlns.'a href="'.$this->clip_href($x).'" title="'.$this->clip_title($x).'">'.$this->clip_img($x).'</'.$this->xmlns.'a>';
		return $clip;
	}
	
	/**
	 * Select a particular small alternate image as active. If requested image not in 
	 * Alternates, last one is set as active.
	 * @param key s Required - request a specific small alternate image as active
	 * @param key x Optional - request a specific project's href.
	 * @return boolean true if requested small exists, false otherwise
	 */
	function choose_small($s,$x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		if(key_exists($s,$this->projects[$x]['small'])){
			foreach($this->projects[$x]['small'] as $t)
				if($this->projects[$x]['small']->key() == $s) break;
			return true;
		}
		return false;
	}
	
	/**
	 * Return entire small Alternates object (iteratable)
	 * @param key x Optionally request a specific project's small Alternates.
	 * @return Alternate small Alternates
	 */
	function smalls($x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		return $this->projects[$x]['small'];
	}
	
	/**
	 * Retrieve src of currently active small Alternate
	 * @param key s Required - key (string or int) of requested small Alternate
	 * @param key x Optional - key (string or int) of a specific project
	 * @return string src of requested small Alternate
	 */
	function small_src($s=null,$x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		if(is_null($s) or !key_exists($s,$this->projects[$x]['small']))
			return $this->projects[$x]['small']->current();
		else
			return $this->projects[$x]['small']->get($s);
	}

	/**
	 * Retrieve alt text of currently active small Alternate
	 * @param key s Required - key (string or int) of requested small Alternate
	 * @param key x Optional - key (string or int) of a specific project
	 * @return string alt text of requested small Alternate
	 */
	function small_alt($s=null,$x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		return "screenshot of ".$this->title($x);
	}

	/**
	 * Retrieve title of currently active small Alternate
	 * @param key s Required - key (string or int) of requested small Alternate
	 * @param key x Optional - key (string or int) of a specific project
	 * @return string title of requested small Alternate
	 */
	function small_title($s=null,$x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		return 'enlarge screenshot';
	}

	/**
	 * Retrieve img html of currently active small Alternate
	 * @param key s Required - key (string or int) of requested small Alternate
	 * @param key x Optional - key (string or int) of a specific project
	 * @return string img html of requested small Alternate
	 */
	function small_img($s=null,$x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		$img = '<'.$this->xmlns.'img src="'.$this->small_src($s,$x).'" alt="'.$this->small_alt($x).'" title="'.$this->small_title().'"/>';
		return $img;
	}

	/**
	 * Retrieve href of currently active small Alternate
	 * @param key s Required - key (string or int) of requested small Alternate
	 * @param key x Optional - key (string or int) of a specific project
	 * @return string href of requested small Alternate
	 */
	function small_href($s=null,$x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		if(is_null($s) or !key_exists($s,$this->projects[$x]['small']))
			return '/portfolio/'.$x.'/'.$this->projects[$x]['small']->key().'/';
//			return '/portfolio4.php?p='.$x.'&amp;i='.$this->projects[$x]['small']->key().'';
		else
			return '/portfolio/'.$x.'/'.$s.'/';
//			return '/portfolio4.php?p='.$x.'&amp;i='.$s.'';
	}
	
	/**
	 * Retrieve html code of linked image of currently active small Alternate
	 * @param key s Required - key (string or int) of requested small Alternate
	 * @param key x Optional - key (string or int) of a specific project
	 * @return string html code of linked image of requested small Alternate
	 */
	function small($s=null,$x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		return '<'.$this->xmlns.'a href="'.$this->small_href($s,$x).'" title="'.$this->small_title($s,$x).'">'.$this->small_img($s,$x).'</'.$this->xmlns.'a>';
	}

	/**
	 * Select a particular big alternate image as active. If requested image not in 
	 * Alternates, first one is set as active.
	 * @param key s Required - request a specific big alternate image as active
	 * @param key x Optional - request a specific project's href.
	 * @return boolean true if requested big exists, false otherwise
	 */
	function choose_big($b,$x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		if(key_exists($b,$this->projects[$x]['big'])){
			foreach($this->projects[$x]['big'] as $t)
				if($this->projects[$x]['big']->key() == $b) break;
			return true;
		}
		return false;
	}
	
	/**
	 * Return entire big Alternates object (iteratable)
	 * @param key x Optionally request a specific project's big Alternates.
	 * @return Alternate big Alternates
	 */
	function bigs($x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		return $this->projects[$x]['big'];
	}
	
	/**
	 * Retrieve src of currently active big Alternate
	 * @param key s Required - key (string or int) of requested big Alternate
	 * @param key x Optional - key (string or int) of a specific project
	 * @return string src of requested big Alternate
	 */
	function big_src($b=null,$x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		if(is_null($b))
			return $this->projects[$x]['big']->current();
		else
			return $this->projects[$x]['big']->get($b);
	}

	/**
	 * Retrieve alt text of currently active big Alternate
	 * @param key s Required - key (string or int) of requested big Alternate
	 * @param key x Optional - key (string or int) of a specific project
	 * @return string alt text of requested big Alternate
	 */
	function big_alt($b=null,$x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		return "screenshot of ".$this->title($x);
	}

	/**
	 * Retrieve title of currently active big Alternate
	 * @param key s Required - key (string or int) of requested big Alternate
	 * @param key x Optional - key (string or int) of a specific project
	 * @return string title of requested big Alternate
	 */
	function big_title($b=null,$x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		return "screenshot of ".$this->title($x);
	}

	/**
	 * Retrieve img (html) of currently active big Alternate
	 * @param key s Required - key (string or int) of requested big Alternate
	 * @param key x Optional - key (string or int) of a specific project
	 * @return string img (html) of requested big Alternate
	 */
	function big_img($b=null,$x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		$img = '<'.$this->xmlns.'img src="'.$this->big_src($b,$x).'" alt="'.$this->big_alt($b,$x).'" title="'.$this->big_title($b,$x).'"/>';
		return $img;
	}

	/**
	 * Retrieve href of currently active big Alternate
	 * @param key s Required - key (string or int) of requested big Alternate
	 * @param key x Optional - key (string or int) of a specific project
	 * @return string href of requested big Alternate
	 */
	function big_href($b=null,$x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		if(is_null($b) or !key_exists($b,$this->projects[$x]['big']))
			return '/portfolio/'.$x.'/'.$this->projects[$x]['big']->key().'/';
		else
			return '/portfolio/'.$x.'/'.$b.'/';
	}
	
	/**
	 * Retrieve html code of linked image of currently active big Alternate
	 * @param key s Required - key (string or int) of requested big Alternate
	 * @param key x Optional - key (string or int) of a specific project
	 * @return string html code of linked image of requested big Alternate
	 */
	function big($b=null,$x=null){
		if(is_null($x) or !key_exists($x,$this->projects)) $x = $this->key();
		return '<'.$this->xmlns.'a href="'.$this->big_href($b,$x).'" title="'.$this->big_title($b,$x).'">'.$this->big_img($b,$x).'</'.$this->xmlns.'a>';
	}
}
?>
