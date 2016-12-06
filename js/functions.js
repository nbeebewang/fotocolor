$(function () {
	//When #kmeans_submit button is clicked, do all the following:
	$("#kmeans_submit").click(function() {
		
		//k is the number of colors the user has selected from the drop-down menu
		var k = $("#kmeans_k").val();
		
		//New_pixels is an array of pixels that is created with the function below
		var new_pixels = kmeansCompression(pixels, k);
		
		//Uncomment the below to see the new pixels printed to the console
		//console.log(new_pixels);
		
		//Calls the function to draw a new image
		var canvas_id = 'canvas'
		generateImg(new_pixels, height, width, canvas_id);
	});
});


function kmeansCompression(pixels, k) {
	//pixels is a 2D array of arrays containing all the pixels in an image.
	//Dimension of each pixel is 3 -- simple RGB integer values
	//k is the number clusters -- color number selected by user

	//Pixel Dimension (R,G,B)
	var D = 3;	

	// Calculate clusters using algorithms from http://harthur.github.io/clusterfck/demos/colors/clusterfck.js
	/*global kmeans_clustering*/
	var clusters = kmeans_clustering.kmeans(pixels, k);

	//Create mapping of points to their mean value 
	var mapping = {};
	for (var i = 0; i < clusters.length; i++) {
		var cluster = clusters[i]; // array of all pixels in cluster i
		if(typeof cluster === 'undefined'){
		    continue;
		};
		//creates an array of D (i.e. 3) zeros
		var sum = Array.apply(null, Array(D)).map(Number.prototype.valueOf,0); 
		//Find mean of all the pixels j in cluster i
		for (var j = 0; j < cluster.length; j++) {
			pixel = cluster[j]; // get the jth pixel in the cluster array
			for (var z = 0; z < pixel.length; z++) { //should just iterate through R, G, and B value
				sum[z] = sum[z] + pixel[z]
			}
		}
		var mean = sum.map(function(x) { return x / cluster.length; }); //average pixel RGB values
		//Map each point in cluster i to that mean.
		for (var j = 0; j < cluster.length; j++) {
			var pixel = cluster[j]; // get the jth pixel in the cluster array
			mapping[pixel.toString()] = mean; //key is pixel array - but convert pixel array to string first since key must be string
		}
	}

	//Create new image by mapping pixels to closest means
	var new_pixels = [];
	for (var i = 0; i < pixels.length; i++) {
		pixel = pixels[i];
		new_pixels.push(mapping[pixel.toString()]);
	}
	
	return new_pixels;
};



//Function to generate the new image from the k-means RGB array
function generateImg(arr, h, w, canvas_id) {
	var canvas = document.getElementsByTagName('canvas')[0];
	canvas.width  = w;
	canvas.height = h;
	$("#" + canvas_id).width(w+"px");
	$("#" + canvas_id).height(h+"px");
	
	
	var ctx = $("#" + canvas_id)[0].getContext('2d');
	var imgData = ctx.getImageData(0, 0, w, h);
	var data = imgData.data;
	
	//Iterates through each pixel 
	for(var i = 0; i < arr.length; i++) {
	        var s = 4 * i;
	        var x = arr[i];
	        data[s] = x[0];
	        data[s + 1] = x[1];
	        data[s + 2] = x[2];
	        data[s + 3] = 255;
	  
	}
	
	ctx.putImageData(imgData, 0, 0);
};