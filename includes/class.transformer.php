<?php
/*
 * Created on Jan 12, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

class Transformer {
	public $usecache=false, $cachefile, $xmlfile, $xslfile, $dependencies=array(), $parameters=array();
	
	private $doc, $xslproc, $email='3am@3amproductions.net';
	
	function __construct($xmlfile=null,$xslfile=null,$cachefile=null,$parameters=array(),$dependencies=array()){
		$this->doc = new DOMDocument();
		$this->xslproc = new XSLTProcessor();

		$this->xmlfile = $xmlfile;
		$this->xslfile = $xslfile;
		$this->cachefile = $cachefile;
		
		if(is_array($parameters))
			foreach($parameters as $p){
				if(count($p) != 3) continue;
				if(array_key_exists('namespace',$p) and array_key_exists('name',$p) and array_key_exists('value',$p)){
					$this->parameters[] = $p;}
				else{
					$this->parameters[] = array('namespace'=>$p[0],'name'=>$p[1],'value'=>$p[2]);}}
		$this->dependencies[] = $xmlfile;
		$this->dependencies[] = $xslfile; 
		$this->dependencies = array_merge($this->dependencies, $dependencies);
		$this->usecache = !is_null($cachefile);
	}
	
	function __toString(){
		$s = "XML File:\t$this->xmlfile\n" .
				"XSL File:\t$this->xslfile\n" .
				"Cache File:\t$this->cachefile\n" .
				"Use Cache:\t" . ($this->usecache ? "true":"false") . "\n" .
				"Dependencies:\n";
		foreach($this->dependencies as $d){
			$s .= "\t\t$d\n";}
		$s .= "Parameters:(Namespace, Name, Value)\n";
		foreach($this->parameters as $p){
			$s .= "\t\t'" . $p['namespace']."', '".$p['name']."', '".$p['value']."'\n";
		}
		return $s;
	}
	function addDependency($file){
		if(is_array($file)){
			foreach($file as $f){
				$dependencies[] = $f;}}
		else{
			$dependencies[] = $file;}
	}
	
	function addParameter($namespace = '', $name, $value){
		$p = array('namespace'=>$namespace,'name'=>$name,'value'=>$value);
		$parameters[] = $p;
	}
	
	function hasExsltSupport(){
		return $this->xslproc->hasExsltSupport();
	}
	
	function registerPHPFunctions(){
		return $this->xslproc->registerPHPFunctions();
	}

	function transform(){
		try{
			// Check Files
			if(is_null($this->xmlfile)){
				throw new Exception('Null XML File');}
			if(is_null($this->xslfile)){
				throw new Exception('Null XSL File');}
			
			// Check and Use Cache
			if($this->usecache){
				if($this->check_cache()){
					if($output = @file_get_contents($this->cachefile)){
						return $output;}
					else{
						throw new Exception('Failed Outputting Cache Contents');}}}
			
			// Load XSL
			if(!@$this->doc->load($this->xslfile)){
				throw new Exception('Failed Loading XSL File');}
			$this->xslproc->importStyleSheet($this->doc);
			
			// Set XSL Parameters
			foreach($this->parameters as $p){
					@$this->xslproc->setParameter($p['namespace'],$p['name'],$p['value']);}
			
			// Load XML
			if(!@$this->doc->load($this->xmlfile)){
				throw new Exception('Failed Loading XML File');}
			
			// Transform (to String or File)
			if($this->usecache){
				if(@$this->xslproc->transformToURI($this->doc,$this->cachefile)){
					if($output = @file_get_contents($this->cachefile)){
						return $output;}
					else{
						throw new Exception('Failed Outputting Cache Contents');}}
				else{
					throw new Exception('Failed Transforming to Cache File');}}
			else{
				if($output = @$this->xslproc->transformToXML($this->doc)){
					return $output;}
				else{
					throw new Exception('Failed Transforming to String');}}
		}
		catch (Exception $e){
      // rethrow, don't email
      throw $e;
			$msg = "Exception:\t" . $e->getMessage() . "\n" .
					"Timestamp:\t" . date(DATE_ATOM) . "\n" .
					"Directory:\t" . getcwd() . "\n" .
					$this->__toString();

			if(include_once('Zend/Mail.php')){
				$mail = new Zend_Mail();
				$mail->setFrom($this->email, 'SteamClaw: 3AM XML Transformer');
				$mail->addTo($this->email, '3AM Productions');
				$mail->setSubject('Transformer Error');
				$mail->setBodyText($msg);
				$mail->send();
			}
			else{
				mail($this->email,'Transformer Error',$msg);
			}
			// Return Cache or False
			if(!is_null($this->cachefile)){
				if($output = @file_get_contents($this->cachefile)){
					return $output;}}
			return false;
		}	
	}
	
	private function check_cache(){
		$cachemtime = @filemtime($this->cachefile);
		$xmlmtime = @filemtime($this->xmlfile);
		$xslmtime = @filemtime($this->xslfile);

		if(!$cachemtime)
			return false;
		if(!$xmlmtime)
			throw new Exception('Bad XML mtime()');
		if(!$xslmtime)
			throw new Exception('Bad XSL mtime()');
		
		foreach($this->dependencies as $d){
			if(@filemtime($d) > $cachemtime)
				return false;
		}
		return true;
	}
}

?>
