<?php
## 
## v1.1	Stable ## 06 August 2004
## v1.2 Stable ## 11 August 2004
######
## Digit Image Displayer
######
## This class generates image version of text plain number
## to be used in  hit/visit counter. 
##
#######
## Author: Huda M Elmatsani
## Email: 	justhuda at netrada.co.id
##
## 06/08/2004
#######
## Copyright (c) 2004 Huda M Elmatsani All rights reserved.
## This program is free for any purpose use.
########
##
## USAGE
## create strip image with numbers "0123456789" inside, 
## each number must be equal in width,
## so, the length of image must be 10 x number width. 
##
## see sample.php for test and usage
## 
## visit http://www.program-ruti.org/digidisplayer/
## for working sample
##
####


class DigiDisplayer {

	/* path to digit strip image directory*/
	var $dir_strip 	 = "strips/";
	var $num_length  = 0;
	var $num_count 	 = 0;
	var $strip_name	 = ""; //file name ie: digit.jpeg
	var $file_strip  = ""; //fullpath file
	var $style_type	 = ""; // strip image type: jpeg, gif, png
	var $digi_type	 = ""; // output image type: jpeg, gif, png
	var $digi_width  = 0;
	var $digi_height = 0;
	//var $borderless  = 1;
	//var $border_width = 0;
	//var $border_color = "";
	//var $border_style = "";

	function DigiDisplayer($count,$strip="",$length=0) {

		$this->num_length 	= $length;
		$this->num_count	= $count;
		$this->strip_name 	= $strip;

	}

	function load_strip() {
		/* pick strip image from image directory */
		$this->file_strip = $this->dir_strip . $this->strip_name;
		if(file_exists($this->file_strip) && $this->strip_name) {

			$extension = $this->get_imagetype($this->file_strip);

			/* create image source from your image strip stock*/
			switch($extension){
				case 'jpeg' :
				case 'jpg' 	:
					$img_strip 	= @imagecreatefromjpeg ($this->file_strip);
					break;
				case 'gif' :
					$img_strip 	= @imagecreatefromgif ($this->file_strip);					
					break;
				case 'png' :
					$img_strip 	= @imagecreatefrompng ($this->file_strip);										break;
			}

		} else {

			/* if fail to load image file, create it on the fly */
			$img_strip 	= $this->draw_strip();
		}

		return $img_strip;
		imagedestroy( $img_strip );

	}


	function display_digit($type='JPEG') {
		/* make it not case sensitive*/
		$this->digi_type = strtolower($type);

		/* draw the image counter  */	
		$this->img = $this->draw_digit();
		
		/* show the image  */			
		switch($this->digi_type){
			case 'jpeg' :
			case 'jpg' 	:
				header("Content-type: image/jpeg");
				imagejpeg($this->img);
				break;
			case 'gif' :
				header("Content-type: image/gif");
				imagegif($this->img);
				break;
			case 'png' :
				header("Content-type: image/png");
				imagepng($this->img);
				break;
			case 'wbmp' :
				header("Content-type: image/vnd.wap.wbmp");
				imagewbmp($this->img);
				break;
		}
	}

	function draw_digit() {		

		$img_strip 		= $this->load_strip();


 		$strip_width 	= imagesx($img_strip); 
		$strip_height 	= imagesy($img_strip); 

		/* slice into 10 pieces */
		$slice_width	= $strip_width/10;
		$slice_height	= $strip_height;

		$x 				= 0;
		$y				= 0;
		$w				= $slice_width;
		$h				= $slice_height;

		for($i=0 ; $i<10 ; $i++){
			$img_pieces[$i]	= $this->slice_image($img_strip,$x,$y,$w,$h);
			$x = $x + $w;
 		}


		if(!$this->num_length) {

			$this->num_length = strlen($this->num_count);

		} else if (strlen($this->num_count) > $this->num_length) {
			/* if length of num_count > num_length, ignore num_length*/
			$this->num_length = strlen($this->num_count);

		} else {

			$this->num_count = str_pad($this->num_count, $this->num_length, "0", STR_PAD_LEFT); 

		}

		$this->digi_width  	= $slice_width * $this->num_length;
		$this->digi_height 	= $strip_height;

		$img_digit = imagecreatetruecolor($this->digi_width, $this->digi_height);

		$str_numbers = preg_split('//', $this->num_count, -1, PREG_SPLIT_NO_EMPTY); 

		$x1 			= 0;
		$y1				= 0;

		/*  arrange the numbers */
		for($i=0 ; $i < count($str_numbers) ; $i ++ ) {

			imagecopyresampled ( $img_digit, 
								$img_pieces[$str_numbers[$i]], 
								$x1, 0, 0, 0, 
								$slice_width, 
								$slice_height,
								$slice_width, 
								$slice_height);
			$x1 = $x1 + $slice_width;

		}

		return $img_digit;
		imagedestroy( $img_digit );

	}

	function draw_strip() {

		$font 			= 5;
		$string 		= "0123456789";
		$string_width 	= imagefontwidth($font) * strlen($string);
		$string_height 	= imagefontheight($font);
		$img_strip 		= @imagecreate ($string_width,$string_height);
		$string_color 	= imagecolorallocate ($img_strip, 255, 255, 255);
		$bg_color 		= imagecolorallocate ($img_strip, 0, 0, 0); 
		imagefill ( $img_strip, 0, 0, $bg_color );
		imagestring ( $img_strip, $font, 0, 0, $string, $string_color );
		return $img_strip;
		imagedestroy( $img_strip );
	}

/* deprecated */
/*

Use Frame Maker class to generate border

	function set_border($width=2,$color="#000000",$style="solid") {

		//$this->borderless 	= 0;
		//$this->border_width = $width;
		//$this->border_color = $color;
	//	$this->border_style = $style;
	}

	function is_borderless() {

		return $this->borderless;

	}
*/

	function get_imagetype($file) {

		$acceptable = array("jpg","jpeg","gif","png");
		/* ask the image type */
		$file_info  = pathinfo($file);
		$extension  = $file_info["extension"];
		
		if(in_array($extension,$acceptable))
			return $extension;
		else
			return null;
	}

    function slice_image($img_src, $x, $y, $width, $height) {
   
		$img_slice = imagecreatetruecolor($width, $height);
		imagecopyresampled($img_slice, $img_src, 0, 0, $x, $y, $width, $height, $width, $height);
        return $img_slice;
		imagedestroy( $img_slice );
    }

	function hex2rgb($color) {

		$color = str_replace('#', '', $color);
		$ret = array(
			'R' => hexdec(substr($color, 0, 2)),
			'G' => hexdec(substr($color, 2, 2)),
			'B' => hexdec(substr($color, 4, 2))
		);
		return $ret;
	}

	// return $gradient_color an array that contain the final gradient 
	// this function is wrote by amelhedi
	function gradient($coldeb, $colfin, $n) { 
		
		$color[deb] = $this->hex2rgb($coldeb); 
		$color[fin] = $this->hex2rgb($colfin); 
		$rgb = array('R', 'G', 'B'); 
		
		// calculate the red, the bleu, and the green gradient 
		foreach ($rgb as $RGB) { 
		  $color[enc][$RGB] = floor( (($color[fin][$RGB]) - ($color[deb][$RGB])) / $n ); 
		  for ($x = 0 ; $x < $n ; $x++)  { 
		   $color[gradient][$RGB][$x] = dechex($color[deb][$RGB] + ($color[enc][$RGB] * $x)); 
		   if (strlen(strval($color[gradient][$RGB][$x])) < 2)  { 
			$color[gradient][$RGB][$x] = '0' . $color[gradient][$RGB][$x]; 
		   } 
		  } 
		} 
		// build the final gradient array 
		for ($i = 0 ; $i < $n ; $i++) { 
		  $gradient_color[] = $color[gradient][R][$i] . $color[gradient][G][$i] . $color[gradient][B][$i]; 
		} 
		return $gradient_color; 
	} 

}


?>