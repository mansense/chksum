<?php 
session_start(); 
include "functions.php";
/*
    file parser helper

    strategy:
    do error checks (in filepointer)
     - check if file is supplied 
     - check if file is valid csv
     - count columns, return c

    get checksum
     - read from begining to end
     - read from col 1 to last
     - accumulate := get diff of max & min
     - return accumulate
     - return array for display
*/    

// clean user data 
function string_clean($string) {
    $string = str_replace(' ', '', $string);                // removes spaces.
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string);   // Removes special chars.
 }

/* initialise variables */
$_SESSION["results_array"]  = "";
$_SESSION["original_array"] = "";    
$_SESSION["checksum"]       = "";

$errors_found = false; 
$filename=$_FILES["file"]["tmp_name"];
$col_count = 0;
$col_counter = -1;
$row_counter = -1;  

//echo $filename;
//echo "<br>"; 


if($_FILES["file"]["size"] > 0){                            // is file ?
    $file = fopen($filename, "r");                          // open for r/o
    while (($emapData = fgetcsv($file, 500000, ",")) !== FALSE){
        $col_count = count($emapData);
        $row_counter += 1; 
        $col_counter = 0;         
        
        // use first column as row reference point instead of range
        $tmax = string_clean($emapData[0]); //-1000000000;
        $tmin = string_clean($emapData[0]); //1000000000;
        $original_array .= "<br>".$emapData[0].' '; 
        
        // inner loop for columns
        for ($i=1;$i<$col_count; $i++){
            
            $val[$i] = string_clean($emapData[$i]);         // clean
            ($val[$i]<$tmin) ? $tmin = $val[$i] : null;              
            ($val[$i]>$tmax) ? $tmax = $val[$i] : null;  
            $original_array .= " ".$emapData[$i]; 
            
          $diff = $tmax - $tmin; 
        }
       
        $cummul8 += $diff; 
        $results_array[$row_counter][$col_counter] = 'Max:'.$tmax;
        $results_array[$row_counter][$col_counter+1] = 'Min:'.$tmin;
        $results_array[$row_counter][$col_counter+2] = 'Diff:'.$diff;
        
    }  // end while
    fclose($file); 

    // return results 
    /* 
        ideally should be feeding into backend db
        but json is good for interaction with browser
    */    
    $_SESSION["results_array"] = json_encode($results_array);   
    $_SESSION["original_array"] = $original_array;    
    $_SESSION["checksum"] = 'Checksum: '.$cummul8;
    $_SESSION["col_count"] = $col_count;
    $_SESSION["row_counter"] = $row_counter;
    
    redirect_to("../index.php");                                    // return


}  else {   // invalid file                           
    $_SESSION["checksum"] = "No valid CSV file found.";     
    redirect_to("../index.php");    
}
?>