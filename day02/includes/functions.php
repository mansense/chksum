<?php
    // handle redirects
	function redirect_to($location){
        if($location!=NULL){
          header("Location: {$location}"); 
          exit; 
        }
       }
?>