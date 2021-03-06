<?php
require("class.phpmailer.php");

class my_phpmailer extends phpmailer {
    // Set default variables for all new objects
		var $to = array(array("3am@3amproductions.net","3AM Productions"));
		var $Mailer   = "mail"; // Alternative to IsMail()
    var $WordWrap = 75;
		
		function validate_name(){
			if($this->FromName != "") return '';
			else return "No name! What do we call you?";
		}
		
		function validate_address(){
			if($this->From == "") return "We need your email address to reply.";
			if(strpos($this->From,'@') !== false) return '';
			else return "We can't reply to this address.";
		}

		function validate_subject(){
			if($this->Subject != "") return '';
			else return "What is this email about?";
		}
		
		function validate_body(){
			if($this->Body != "") return '';
			else return "What is the point of an empty email?";
		}
		
    // Print current message as in table format
    function print_mail($table_id = null) {
			// Open Table, Open Head
			$id = is_null($table_id) ? null : 'id="'.$table_id.'" ';
			$msg = '<table ' . $id . '" summary="Contents of Email generated by PHPMailer"><thead>';
			
    			// Print TO's
    			$msg .= '<tr><th>TO:</th><td>';
    			foreach($this->to as $to) $msg .= $to[1] . ' &lt;' . $to[0] . '&gt;; ';
    			$msg .= '</td></tr>';
    
    			// Print CC's
    			if(!is_null($this->cc)){
      			$msg .= '<tr><th>CC:</th><td>';
      			foreach($this->cc as $cc)	$msg .= $cc[1] . ' &lt;' . $cc[0] . '&gt;; ';
      			$msg .= '</td></tr>';
    			}
    			// Print BCC's
    			if(!is_null($this->bcc)){
      			$msg .= '<tr><th>BCC:</th><td>';
      			foreach($this->bcc as $bcc)	$msg .= $bcc[1] . ' &lt;' . $bcc[0] . '&gt;; ';
      			$msg .= '</td></tr>';
    			}
    			// Print FROM
    			$msg .= '<tr><th>FROM:</th><td>' . $this->FromName . ' &lt;' . $this->From . '&gt;' . '</td></tr>';
    
    			// Print SENDER
    			if(!is_null($this->ReplyTo)){
      			$msg .= '<tr><th>Reply-To:</th><td>';
      			foreach($this->ReplyTo as $to) $msg .= $to[1] . ' &lt;' . $to[0] . '&gt;; ';
      			$msg .= '</td></tr>';
    			}			
    			// Print ConfirmReadingTo
    
    			// Print Headers
    
    			// Print Subject
    			$msg .= '<tr><th>SUBJECT:</th><td>' . $this->Subject . '</td></tr>';
  
			// Close Header, Open Body
			$msg .= '</thead><tfoot></tfoot><tbody>';
  
    			// Print Body
    			$msg .= '<tr><th>BODY:</th><td></td></tr><tr><td colspan="2">' . $this->Body . '</td></tr>';
    
    			// Print AltBody
    
			// Close Body, Close Table
			$msg .= '</tbody></table>';

			return $msg;
    }
}
?>
