<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="FotoColor">
    <meta name="author" content="Nicasia Beebe-Wang">
    <link rel="shortcut icon" href="img/camera.ico">
    <title>FotoColor</title>

	<!-- Load style sheets -->
	<link rel="stylesheet" type="text/css" href="photoeffects.css" />
	
	<!-- Google Font -->
	<link href='https://fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Dosis:800' rel='stylesheet' type='text/css'>

	<!-- Load any supplemental Javascript libraries here -->
	<script type="text/javascript" src="js/jquery-1.11.3.js"></script>
	<script type="text/javascript" src="js/kmeans_clustering.js"></script>

	<!-- Load main javascript here -->
	<script type="text/javascript" src="js/functions.js"></script>

  </head>
  <body>
    <div id="header">
  		<table style="width:100%">
        <tbody>
          <tr>
           <td rowspan="3" align="left"> <a href="index.php"><font size="12">FotoColor</font></a> </td>
           <td align="right"> <a href="index.php"><font size="3">Main</font></a> </td>
          </tr>
          <tr>
           <td align="right"> <a href="about.html"><font size="3">About</font></a></td>
          </tr>
          <tr>
           <td align="right"> <a href="instructions.html"><font size="3">Instructions</font></a></td>
          </tr>
        </tbody>
      </table>
  	</div>
  	
  	<div id="main_index">
    	<!--<img  id="colorwheel" src="img/colorwheel.png" align="right">-->
  	  <div id="uploadarea">
  	    <form method="POST" action="upload.php" enctype="multipart/form-data">
      		<label for="file"><font size="8"> Get started by uploading a picture:</font> </label>
      		<br>
      		<br>
      		<input type="file" name="file" id="choose_button"> 
      		<br>
      		<br>
      		<input type="submit" value = "Upload" class="buttons">
	      </form>
  	  </div>
  	</div>
    
    <div id="footer_index">
      Website created by Nicasia Beebe-Wang, CS50 2015, Harvard University
    </div>
  
  
  </body>
</html>	
