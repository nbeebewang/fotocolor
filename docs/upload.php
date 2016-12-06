<?php
	ini_set('memory_limit', '512M');
	// configuration
  	require("includes/config.php"); 
	
	//Check if the file is well uploaded
	if($_FILES['file']['error'] > 0) { echo 'Error during uploading, try again'; }
	
	//Set up valid image extensions
	$extsAllowed = array( 'jpg', 'png',);
	
	$extUpload = strtolower( substr( strrchr($_FILES['file']['name'], '.') ,1) ) ;
	//Check if the uploaded file extension is allowed
	
	if (in_array($extUpload, $extsAllowed) ) { 
	
	//Upload the file on the server
	
	$name = "img/{$_FILES['file']['name']}";
	$result = move_uploaded_file($_FILES['file']['tmp_name'], $name);
	
	if($result)
	{
	  render("uploaded.php", ["title" => "ColorFoto Options", "name" => $name]); }
	} 
	else 
	{ 
	  apologize("Not a valid file!");
	}
	
?>