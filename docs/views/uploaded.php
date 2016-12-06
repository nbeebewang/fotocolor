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
               <td align="right"> <a href="index.php"><font size="3">Main</font></a> </td>
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
        <table style="width:100%" id="display_table">
            <tr>
                <th rowspan="6" id="orig_pic">
                    <?php
                    ini_set('memory_limit', '512M');
                    //Check filesize. If >10KB, reject the image
                    /*if (filesize($name)>10000)
                    {
                        apologize("Your file is too large.");
                    }*/
                    
                    // Create resourse form either png or jpg
                    $info = new SplFileInfo($name);
                    $ext = $info->getExtension();
                    if ($ext === "png")
                    {
                        $picture = imagecreatefrompng($name);
                    }
                    else if ($ext === "jpg")
                    {
                        $picture = imagecreatefromjpeg($name);
                    }

                    //Get width and height from image
                    $width = getimagesize($name)[0];
                    $height = getimagesize($name)[1];
                    
                    //If area is greater than 250000 pixels, reject image
                    $area = $width * $height;
                    if($area > 250000)
                    {
                        apologize("We can't upload a file larger than 250,000 pixels.");
                    }
                    
                    //Create empty arrays to be filled by iterating through the image resource 
                    $rgb = array(array());
                    $r = array(array());
                    $g = array(array());
                    $b = array(array());
                    $counter = 0;
                    $rgb_arr = array();
                     
                    //Iterate through rows of picture    
                    for($y=0; $y<$height; $y++)
                    {
                        //Iterate through columns of each row of picture
                        for($x=0; $x<$width; $x++)
                        {
                            //Get index of color at each pixel
                            $rgb[$x][$y] = imagecolorat($picture, $x, $y);
                            
                            //From index of color, get R, G, and B values at each pixel
                            $r[$x][$y] = ($rgb[$x][$y] >> 16) & 0xFF;
                            $g[$x][$y] = ($rgb[$x][$y] >> 8) & 0xFF;
                            $b[$x][$y] = $rgb[$x][$y] & 0xFF;
                            
                            //Add [r, g, b] array to a 1D array of pixels (for javascript k-means stuff)
                            $rgb_arr[$counter] = array($r[$x][$y], $g[$x][$y], $b[$x][$y]);
                            $counter++;
                        }
                    }
                    
                    //Start a session with R, G, B arrays, width, height, and name of img
                    session_start();
                    $_SESSION['r'] = $r;
                    $_SESSION['g'] = $g;
                    $_SESSION['b'] = $b;
                    $_SESSION['width'] = $width;
                    $_SESSION['height'] = $height;
                    $_SESSION['name'] = $name;
                    
                    //Display the image in the left panel 
                    print("<img src={$name} min-width='300px' max-width='500px' >");
                    
                    //Pass some PHP variables  to javascript ?>
                    <script>
                        var pixels = JSON.parse('<?php echo json_encode($rgb_arr); ?>');
                        var height = JSON.parse('<?php echo json_encode($height); ?>');
                        var width = JSON.parse('<?php echo json_encode($width); ?>');
                    </script>
                    
                    <canvas id="canvas" height = "100%" width = "100%" min-width='300px' max-width='500px' > ></canvas>
                    
                </th>
            </tr>
            <tr> <td> 
                <p> GRAYSCALE
                <input type='button' value='Submit' onclick=window.open("views/grayscale.php") class="buttons">
                </p>
            </td> </tr>
            <tr> <td>
                <form action="views/colorselect.php" method="post">
                    <br>COLORSELECT 
                    <p>
                        Color 1:
                        <input name="color1" class="jscolor" value="ffffff">
                    
                        Color 2:
                        <input name="color2" class="jscolor" value="ffffff">
                    </p>
                
                    <p>
                        Color 3:
                        <input name="color3" class="jscolor" value="ffffff">
                    
                        Color 4:
                        <input name="color4" class="jscolor" value="ffffff">
                    </p>
                    <input type="submit" class="buttons">
                </form>
            </td> </tr>
            <tr> <td>
                <form action="views/colorpop.php" method="post">
                    <br><br>COLORPOP 
                    <p>
                        Color 1:
                        <input name="color1" class="jscolor" value="ffffff">
                    
                        Color 2:
                        <input name="color2" class="jscolor" value="ffffff">
                    </p>
                
                    <p>
                        Color 3:
                        <input name="color3" class="jscolor" value="ffffff">
                    
                        Color 4:
                        <input name="color4" class="jscolor" value="ffffff">
                    </p>
                     Similarity Requirement:    strict <input type="range" name="slider" min="0" max="10"> lenient
                    <br><input type="submit" class="buttons">
                </form>
            </td> </tr>
            <tr> <td>
                    <p><br>K-MEANS COMPRESSION </p>
                    <p>
                        Number of Colors:
                        <select id="kmeans_k">
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    <input id="kmeans_submit" type="submit" class="buttons">
                    </p>
                
            </td> </tr>
        </table>
  	</div>
    

    <div id="footer">
        Website created by Nicasia Beebe-Wang, CS50 2015, Harvard University
    </div>
  
    
  </body>
</html>	
