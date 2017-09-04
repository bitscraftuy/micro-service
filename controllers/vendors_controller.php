<?php

class VendorsController{
	public function index() {

		// we store all the posts in a variable
    //?controller=vendors&action=index 
    $message = "";
    $error = "";
    $collection = [];

    
    $vendors = Vendor::all();
    $collection[] = $vendors;

    if (empty($vendors)) {
      $message = "No vendors found";
      $error = 1;
    } else {
      $message = "Vendors found: " . count($vendors);
    }
    
    $view = "index";
    require_once ('views/generic/jsonResponse.php');  
    //require_once ('views/vendors/index.php');  
    
     
	}

	public function show() {

		
      // ?controller=vendors&action=show&id=x
    $message = "";
    $error = 0;
    $collection = [];    
        
      if (!isset($_GET['id']))
        return call('pages', 'error');

      // we use the given id to get the right post
      $vendor = Vendor::find($_GET['id']);
        $collection[]=$vendor;

      if ($vendor -> id == NULL) {
        $message = "Vendor not found";
        $error = 1;
      } else {
        $message = "Vendor found: " . count($vendor);
        $error = 0;
      }


      $view = "show";
        require_once ('views/generic/jsonResponse.php');
      //require_once('views/vendors/show.php');

	}
    
    public function getDefaultVendor(){
        $message = "";
        $error = 0;
        $collection = [];    
        
        $vendor = Vendor::findDefaultVendor();
        $collection[]=$vendor;

          if ($vendor -> id == NULL) {
            $message = "Vendor not found";
            $error = 1;
          } else {
            $message = "Vendor found: " . count($vendor);
            $error = 0;
          }


          $view = "show";
            require_once ('views/generic/jsonResponse.php');
    }

  
}

?>