<?php

class ClientsController{
	public function index() {

		// we store all the posts in a variable
    //?controller=clients&action=index 
    $message = "";
    $error = "";
    $collection = [];

    
    $clients = Client::all();
        
    $collection[]=$clients;

    if (empty($clients)) {
      $message = "No clients found";
      $error = 1;
    } else {
      $message = "Clients found: " . count($clients);
    }
    
    $view = "index";
    require_once ('views/generic/jsonResponse.php');  
    //require_once ('views/clients/index.php');  
    
     
	}

	public function show() {

		
      // ?controller=clients&action=show&id=x
    $message = "";
    $error = 0;
        $collection = [];
      if (!isset($_GET['id']))
        return call('pages', 'error');

      // we use the given id to get the right post
      $client = Client::find($_GET['id']);
    $collection[]=$client;

      if ($client -> client_id == NULL) {
        $message = "Client not found";
        $error = 1;
      } else {
        $message = "Client found: " . count($client);
        $error = 0;
      }


      $view = "show";
        require_once ('views/generic/jsonResponse.php');
      //require_once('views/clients/show.php');

	}
    
    public function findByEmail(){
         // ?controller=clients&action=show&id=x
    $message = "";
    $error = 0;
        $collection = [];
      if (!isset($_GET['email']))
        return call('pages', 'error');

      // we use the given id to get the right post
      $client = Client::findByEmail($_GET['email']);
    $collection[]=$client;

      if ($client -> id == NULL) {
        $message = "Client not found";
        $error = 1;
      } else {
        $message = "Client found: " . count($client);
        $error = 0;
      }


      $view = "show";
        require_once ('views/generic/jsonResponse.php');
      //require_once('views/clients/show.php');
    }
    
    
    public function add() {
   
    //?controller=users&action=add&roles_id=1&username=miname&dateOfBirth=2000-06-05%2000:00:00&firstname=papap&lastname=popo&pass=1234&phone=565656&email=nono@d.com&current_role=1
    $message = "";
    $error = 0;
    $collection = [];
    $user = new Client();
    $allowed = true;


    if (!isset($_REQUEST['email']) || !isset($_REQUEST['vendorId']))//required fields(email, vendorId)
      return call('pages', 'error');

    $vendorId     = $_REQUEST['vendorId'];
    $email    = (isset($_REQUEST['email']))    ? $_REQUEST['email']    : '';
        
    $exists = Client::findByEmail($email); 
    if ($exists -> id == NULL){
        
        $user = Client::add($email, $vendorId);

        $collection[] = $user;


          if(gettype($user) == "object"){
            if($user -> id != NULL || $user -> id != 0) {
                $message = "Client added";
            }
          }

          if(gettype($user) == "array"){
            if($user['id'] == 0){
              $message = "Client already registered";
              $error = 1;
            }else if($user['id'] == -1){
              $message = "Not valid e-mail account";
              $error = 2;
            }
          }
        
    }else{
        $message = "Client already registered";
        $error = 3 ;
    }

    

    require_once ('views/generic/jsonResponse.php');

  }


}

?>