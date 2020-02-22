<?php

    // class for parsing apache log files
    class CLF_Log_Parser{
        public $rowsParsed;
        public $bytesTransfered;
        private $fp;
        private $file_name;
        
        public function __construct($file){
        	$this->file_name = $file;
        }
        
        // main function for parsing the lines of log file
        public function parse($data){
            $pattern = "/(([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)\ ([\-])\ ([^\ ]+)\ \[([0-9]+\/[a-zA-Z]+\/[0-9]+:[0-9]+:[0-9]+:[0-9]+\ [\+\-0-9]+)\]\ \"([a-zA-Z]+)\ ([^\"]+)\ ([^\"]+)\"\ ([0-9]+)\ ([0-9]+)\ \"([^\"]+)\"\ \"([^\"]+)\")/";
            $matches = array();
            if (preg_match($pattern, $data, $matches)){
                $request['ip'] = $matches[2];
                $request['username'] = $matches[4];
                $request['time'] = $this -> parseTime($matches[5]);
                $request['date'] = $this -> parseDate($matches[5]);
                $request['method'] = $matches[6];
                $request['request'] = $matches[7];
                $request['protocol'] = $matches[8];
                $request['code'] = $matches[9];
                $request['size'] = $matches[10];
                $request['referer'] = $matches[11];
                $request['useragent'] = $matches[12];
            }
            $this -> rowsParsed++;
            $this -> bytesTransfered += $request['size'];
            return $request;
        }
        
		public function open($filename = null)
		{
			$filename = is_null($filename) ? $this->file_name : $filename;
			$this->fp = fopen($filename, 'r'); // open the file
			if (!$this->fp)
			{
				return false; // return false on fail
			}
			return true; // return true on sucsess
		}

		public function close()
		{
			return fclose($this->fp); // close the file
		}
        
		// gets a line from the log file
		public function get_line()
		{
			if (feof($this->fp))
			{
				return false;
			}
			$bits=fgets($this->fp);
			return $bits;
		}
        
        // function to parse date into Y-m-d format, you can also edit this to parse the date into unix timestamp
        private function parseDate($date){
            if (empty($date)){
                trigger_error('Date empty!', E_USER_WARNING);
            }
            list($d, $M, $y, $h, $m, $s, $z) = sscanf($date, "%2d/%3s/%4d:%2d:%2d:%2d %5s");
            return date('Y-m-d', strtotime("$d $M $y $h:$m:$s $z"));
        }
        
        // function to parse time in H:i:s format
        private function parseTime($date){
            list($d, $M, $y, $h, $m, $s, $z) = sscanf($date, "%2d/%3s/%4d:%2d:%2d:%2d %5s");
            return date('H:i:s', strtotime("$d $M $y $h:$m:$s $z"));
        }
    }
?>