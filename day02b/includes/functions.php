<?php
    // handle redirects
	function redirect_to($location){
          if($location!=NULL){
            header("Location: {$location}"); 
           exit; 
        }
       }

  // sanitize user input     
  function string_clean($string) {
      $string = str_replace(' ', '', $string);                // removes spaces.
      return preg_replace('/[^A-Za-z0-9\-]/', '', $string);   // Removes special chars.
  }
    
?>