<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="FotoColor">
    <meta name="author" content="Nicasia Beebe-Wang">
    <link rel="shortcut icon" href="../img/camera.ico">
    <title>FotoColor</title>

	<!-- Load style sheets -->
	<link rel="stylesheet" type="text/css" href="../photoeffects.css" />
	
	<!-- Google Font -->
	<link href='https://fonts.googleapis.com/css?family=Dosis:800' rel='stylesheet' type='text/css'>

	<!-- Load any supplemental Javascript libraries here -->
	<script type="text/javascript" src="../js/jquery-1.11.3.js"></script>
	<script type="text/javascript" src="../js/kmeans_clustering.js"></script>

	<!-- Load main javascript here -->
	<script type="text/javascript" src="../js/functions.js"></script>
	<script type="text/javascript" src="../js/jscolor.js"></script>

  </head>
  
  <body>
    <div id="header">
  	    <table style="width:100%">
            <tbody>
              <tr>
               <td rowspan="3" align="left"> <a href="../index.php"><font size="12">FotoColor</font></a> </td>
               <td align="right"> <a href="../index.php"><font size="3">Main</font></a> </td>
              </tr>
              <tr>
               <td align="right"> <a href="../about.html"><font size="3">About</font></a></td>
              </tr>
              <tr>
               <td align="right"> <a href="../instructions.html"><font size="3">Instructions</font></a></td>
              </tr>
            </tbody>
        </table>
  	</div>
  	
  	<div id="main">
        <table style="width:100%">
            <tr>
                <th> ORIGINAL</th>
                <th> GRAYSCALE</th>
            </tr>
            <tr> 
            <td>
                <?php 
                    ini_set('memory_limit', '512M');
                    session_start();
                    //If theres no picture info stored in session, redirect to the main page
                    if ( (!isset($_SESSION['width'])))
                    {
                        if (headers_sent($file, $line))
                        {
                            trigger_error("HTTP headers already sent at {$file}:{$line}", E_USER_ERROR);
                        }
                        header("Location: ../index.php");
                        exit;
                    }
                    else
                    {
                        //Create variable names for each user-selected color from the Post request
                        $width = $_SESSION['width'];
                        $height = $_SESSION['height'];
                        $oldr = $_SESSION['r'];
                        $oldg = $_SESSION['g'];
                        $oldb = $_SESSION['b'];
                        $name = $_SESSION['name'];
                    }
                    
                    //Insert the image into the left side of the webpage
                    print("<img src=../{$name} max-width='500px' </td>");
                    
                    //Create a new image that's the size of the original image
                    $im = imagecreatetruecolor($width, $height);
                    
                    //Iterate through rows of picture
                    for($x=0; $x<$width; $x++)
                    {
                        //Iterate through columns of each row of picture
                        for($y=0; $y<$height; $y++)
                        {
                            //For the current pixel, take the average of the R, G, and B
                            //Values. The average then becomes R=G=B value for the grayscale image
                            $avg = ($oldr[$x][$y] + $oldg[$x][$y] + $oldb[$x][$y])/3;
                            $col = imagecolorallocate($im, $avg, $avg, $avg);
                            imagesetpixel ($im , $x, $y, $col );
                        }
                    }
                    
                    //Create png from the image $im
                    imagepng($im, "../img/grayscale/{$name}");
                    
                    //Display the new image in the right pannel
                    print(
                    "<td>
                        <img src=../img/grayscale/{$name} max-width='500px'>
                    </td>")
                    ?>

            </tr>
        </table>
  	</div>

    <div id="footer">
        Website created by Nicasia Beebe-Wang, CS50 2015, Harvard University
    </div>

  </body>
</html>	
