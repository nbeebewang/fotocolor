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
                <th> COLORSELECT</th>
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
                        $color1 = $_POST['color1'];
                        $color2 = $_POST['color2'];
                        $color3 = $_POST['color3'];
                        $color4 = $_POST['color4'];
                        
                        // Create array of user selected hex values and rgb_arr to compare image pixels to it
                        $hex_arr = array($color1, $color2, $color3, $color4);
                        $rgb_arr = array(array());
                    }
                    
                    // Breaks down user selected colors to r,g,b array
                    foreach($hex_arr as $hex)
                    {
                        $r_val = hexdec(substr($hex,0,2));
                        $g_val = hexdec(substr($hex,2,2));
                        $b_val = hexdec(substr($hex,4,2));
                        $rgb_vals = array($r_val, $g_val, $b_val);
                        array_unshift($rgb_arr, $rgb_vals);
                    }
                    
                    //Takes picture information from $_SESSION
                    $width = $_SESSION['width'];
                    $height = $_SESSION['height'];
                    $oldr = $_SESSION['r'];
                    $oldg = $_SESSION['g'];
                    $oldb = $_SESSION['b'];
                    $name = $_SESSION['name'];
                    
                    //Insert the image into the left side of the webpage
                    print("<img src=../{$name} max-width='500px'> </td>");
                    
                    //Create a new image that's the size of the original image
                    $im = imagecreatetruecolor($width, $height);
                    
                    //Iterate through rows of picture
                    for($x=0; $x<$width; $x++)
                    {
                        //Iterate through columns of each row of picture
                        for($y=0; $y<$height; $y++)
                        {
                            
                            //Create a distance array for each pixel
                            //One element for each of the 4 color's distance values  
                            //from current pixel
                            $dist_arr = array();
                            $cols = array(3,2,1,0);
                            foreach($cols as $num)
                            {
                                $dist_r = $oldr[$x][$y] - $rgb_arr[$num][0];
                                $dist_g = $oldg[$x][$y] - $rgb_arr[$num][1];
                                $dist_b = $oldb[$x][$y] - $rgb_arr[$num][2];
                                $dist = ($dist_r * $dist_r) + ($dist_g * $dist_g) + ($dist_b * $dist_b);
                                array_unshift($dist_arr, $dist);
                            }    
                        
                            //From each pixel's distance array to the 4 colors, 
                            //identify the color with the shortest distance
                            $min_array = array_keys($dist_arr, min($dist_arr));
                            $min_color_num = 4 - $min_array[0];

                            //Sets current pixel to user-selected color with minimum distance
                            if($min_color_num === 1){
                                $col = imagecolorallocate($im, $rgb_arr[3][0], $rgb_arr[3][1], $rgb_arr[3][2]);
                                imagesetpixel ($im , $x, $y, $col );
                            }
                            else if($min_color_num === 2){
                                $col = imagecolorallocate($im, $rgb_arr[2][0], $rgb_arr[2][1], $rgb_arr[2][2]);
                                imagesetpixel ($im , $x, $y, $col );
                            }
                            else if($min_color_num === 3){
                                $col = imagecolorallocate($im, $rgb_arr[1][0], $rgb_arr[1][1], $rgb_arr[1][2]);
                                imagesetpixel ($im , $x, $y, $col );
                            }
                            else {
                                $col = imagecolorallocate($im, $rgb_arr[0][0], $rgb_arr[0][1], $rgb_arr[0][2]);
                                imagesetpixel ($im , $x, $y, $col );
                            }
                        }
                    }
                    
                    //Create png from the image $im
                    imagepng($im, "../img/colorselect/{$name}");
                    
                    //Display the new image in the right pannel 
                    print(
                    "<td>
                        <img src=../img/colorselect/{$name} max-width='500px'>
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
