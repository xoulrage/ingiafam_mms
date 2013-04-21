<?php 

/*
  File        : class/class-admin-image.php
  Description : Image Business Object Class 
  Ver         : 1.0
  Created by  : RYC
*/

class image
{

  var $imgSrc, $myImage, $cropHeight, $cropWidth, $x, $y, $thumb; 
   
  // constructor
  function __construct()
  {
    // do nothing
  }
  
  function setImage($image)
  {

    //Your Image
    $this->imgSrc = $image; 
                     
    //getting the image dimensions
    list($width, $height) = getimagesize($this->imgSrc); 
                     
    //create image from the jpeg
    $this->myImage = imagecreatefromjpeg($this->imgSrc) or die("Error: Cannot find image!"); 


    if($width > $height) 
    {
      $biggestSide = $width;
      $smallestSide = $height;      
    } else {
      $biggestSide = $height;
      $smallestSide = $width;
    }
    
    $difference = $smallestSide / $biggestSide;
    
    //echo $difference;
    
    if ($difference >= 0.50)
    {
      //The crop size will be half that of the largest side 
      $cropPercent = .5; // This will zoom in to 50% zoom (crop)
      $this->cropWidth   = $biggestSide*$cropPercent; 
      $this->cropHeight  = $biggestSide*$cropPercent; 
    
    } else { 
    
      // use smallest length (to prevent thumbnail images with blank areas created)                
      $cropPercent = 1;
      $this->cropWidth   = $smallestSide*$cropPercent; 
      $this->cropHeight  = $smallestSide*$cropPercent; 
    }
                     
    //getting the top left coordinate
    $this->x = ($width-$this->cropWidth)/2;
    $this->y = ($height-$this->cropHeight)/2;

  }
  
  function createThumb($p_thumbsize)
  {
    if (!($p_thumbsize))
    {
      $p_thumbsize = 80; // will create a 80 x 80 thumb
    }                

    $this->thumb = imagecreatetruecolor($p_thumbsize, $p_thumbsize); 

    imagecopyresampled($this->thumb, $this->myImage, 0, 0,$this->x, $this->y, $p_thumbsize, $p_thumbsize, $this->cropWidth, $this->cropHeight); 
  } 
  
  function renderImage($p_quality=100)
  {                
    header('Content-type: image/jpeg');
    imagejpeg($this->thumb, NULL, $p_quality);
    imagedestroy($this->thumb); 
  }    
  
  function saveImage($p_path, $p_filename, $p_quality=100)
  {
    imagejpeg($this->thumb, $p_path . $p_filename, $p_quality);
    imagedestroy($this->thumb); 
  }
  
}

?>