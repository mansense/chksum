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
     - accumulate := get checksm of max & min
     - return accumulate
     - return array for display
*/    

// clean user data 

/* initialise variables */
$_SESSION["results_array"]  = "";
$_SESSION["original_array"] = "";    
$_SESSION["checksum"]       = "";

$errors_found = false; 
$filename=$_FILES["file"]["tmp_name"];
$col_count = 0;
$col_counter = -1;
$row_counter = -1;  
$checksm       =   0;

//echo $filename;
//echo "<br>"; 


if($_FILES["file"]["size"] > 0){                            // is file ?
    $file = fopen($filename, "r");                          // open for r/o
    while (($emapData = fgetcsv($file, 500000, ",")) !== FALSE){
        $col_count = count($emapData);
        $row_counter += 1; 
        $col_counter = 0;         
        $divisor = string_clean($emapData[$row_counter]);   
        //print_r($emapData);
        // inner loop for columns
        foreach($emapData as $mappedData){
              
          //  for ($j=0;$j<$col_count; $j++){
                // quotient = dividend  / divisor
                // set dividend
                // set divisor
                $col_counter+=1;
                
                for($i=0; $i<$col_count; $i++) {
                    $dividend = string_clean($emapData[$i]);
                    //$remainder = round($dividend % $mappedData,1);                    
                    $remainder = round($mappedData/$dividend,1);                    

                    if(($remainder>1) and ($mappedData%$dividend==0)){
                        $checksm += $remainder; 
                        $response .= '[ '.$mappedData.' / '.$dividend.'] <br/> '; 
                    } 
            }
        }
    }  // end while
    fclose($file); 

    // return results 
    /* 
        ideally should be feeding into backend db
        but json is good for interaction with browser
    */    
    //echo 'Checksum is: '.$checksm;
    $_SESSION["checksum"] = 'Checksum: '.$checksm;
    $_SESSION['results_array'] = $response; 
    $_SESSION["col_count"] = $col_count;
    $_SESSION["row_counter"] = $row_counter;
    
    redirect_to("../index.php");                                    // return


}  else {   // invalid file                           
    $_SESSION["checksum"] = "No valid CSV file found.";     
    redirect_to("../index.php");    
}
?>