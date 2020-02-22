<?php
/*
	Example usage:
	
	
$js = new JSLink($dir,$relrootdir,$indicator);
	Where
	 - $dir is javascript directory relative to executing php script
	 - $relrootdir is javascript directory relative to webroot (will be used for actual src in link)
	 - $indicator is in javascript file as comment leading the javascript filename to be included
	 	 default is: php-include
		 EX javascript:
		 		//php-include somefile.js
		 		
$js->request($files);
	Where
	 - $files is an array of javascript filenames to be linked
	   EX: array('accesskeys.js')

echo $js->jslink();
	This line actually prints the <script> tags
*/

class JSLink {
    protected $dir;
    protected $relrootdir;
    protected $html;
    protected $requests;
    protected $indicator; 
    protected $dependencies;

    function __construct(){
        $this->html = null;
        $this->requests = array();
        $this->dependencies = array();
    }

    function set_dir($d = null){
        $this->dir = $d;
    }

    function set_relrootdir($rrd = null){
        $this->relrootdir = $rrd;
    }

    function set_indicator($i = 'php-include'){
        $this->indicator = $i;
    }

    function build($js){
        $depends = array();
        $y = array_push($this->requests,$js);
        if(strpos($js,'http://') !== 0 and strpos($js,'https://') !== 0 and $lines = file($this->dir.$js)){
            foreach($lines as $line){
                if(stripos($line,$this->indicator) !== false){
                    $filename = trim(substr($line,stripos($line,$this->indicator)+strlen($this->indicator)));
                    if(!in_array($filename,$this->requests)){
                        $depends = array_merge($depends,$this->build($filename));
                        $y = array_push($depends,$filename);
                        $depends = array_unique($depends);
                    }
                }
            }
        }
        $y = array_push($depends,$js);
        $depends = array_unique($depends);
        return $depends;
    }

    function request($req = array()){
        if(is_array($req)){
            foreach($req as $js){
                $this->dependencies = array_unique(array_merge($this->dependencies, $this->build($js)));
            }
        }
        else $this->dependencies = array_unique(array_merge($this->dependencies, $this->build($req)));
    }

    function deliver(){
        $x = null;
        foreach($this->dependencies as $d){
        	if(strpos($d,'http://') !== 0 and strpos($d,'https://') !== 0)
                $d = $this->relrootdir . $d;
            $x .= '<script type="text/javascript" src="'.$d.'"></script>'."\n\t";
        }
        return $x;
    }
}
?>
