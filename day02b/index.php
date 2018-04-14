<?php 
	session_start(); 
	include "includes/functions.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css" rel="stylesheet" type="text/css">
<title>Checksum</title>

<link rel="stylesheet" type="text/css" href="css/style.css">

<script>
	function show_progress(){
		document.getElementById("progress_bar_div").style.display = "inline-table";
	}

	// toggle results section 
	function show_results(c){
		if ( c ) {
			document.getElementById("div_results").style.display = "block";
		  } else {
			document.getElementById("div_results").style.display = "none";
		}	
	}
</script>

<style>
	#progress_bar_div {
		display: none;
   }
</style>	

</head>

<body class="mainbody">
	<div class="centerd">
		<div id="progress_bar_div">
			working... 
		</div>
		<div class="body-title">
			CHECKSUM CALCULATOR
		</div>

	<!-- GET INPUT FILE -->		
	<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->

		<div class="file-input">
			<form class="form-horizontal well" action="includes/fileparser.php" method="post" 
					name="file_parser" enctype="multipart/form-data">

				<fieldset>

					<legend>Select</legend>
					<p> Please select a CSV file.	
						<div class="control-group">
							<div class="controls">
								<input type="file" name="file" id="file" class="input-large">
							</div>
						</div>
					<p> 
						<div class="button-select">
							<div class="controls">
								<button type="submit" id="btn-submit" name="btn_submit"  class = "btn-submit"
										data-loading-text="Loading... Please Wait" 
										onclick="calculate()">CALCULATE
								</button>
							</div>
						</div>
				</fieldset>
			</form>	
		</div>	


		 <?php include "layouts/footer.php"?>
		</div> <!-- body title -->

		<!-- DISPLAY RESULTS -->
		<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
		<div id="div_results" class="body-output">
				COLUMNS: <?php echo $_SESSION["col_count"]; ?>		<br/>
				ROWS: <?php echo $_SESSION["row_counter"]; ?>		<br/>
				RESULTS: <br/><?php echo $_SESSION["results_array"]; ?>	<br/>
				<?php //echo $_SESSION["results_array"]; ?>	<br/>

				<?php 
					// output data neatly
					$rc = $_SESSION["row_counter"];
					$cc = $_SESSION["col_count"];

				?>	
														<br/>				
		<?php echo $_SESSION["checksum"]; ?>			<br/>
		</div>

	<!-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->

	</div> <!-- main body -->

	<script>
		<?php 
			// display grid only if there is data
			if ($_SESSION["checksum"]>"") {
				echo 'show_results(1);'; 
			  } else {
				echo 'show_results(0);';
			}
		?>
	</script>
</body>
</html>