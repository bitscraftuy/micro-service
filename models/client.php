<?php
class Client {
    public $id;
    public $email;
    public $vendorId;
    public $createdAt;
    public $updatedAt;

  	public function __construct($id = NULL, $email = '', $vendorId = '', $createdAt = '', $updatedAt = '') {
     	  $this->id         = $id;
          $this->email      = $email;
          $this->vendorId   = $vendorId;
          $this->createdAt  = $createdAt;
          $this->updatedAt  = $updatedAt;
    }


    public static function all(){
      $list = [];
      $db = Db::getInstance();

      $req = $db->query("SELECT c.* FROM wp_clients c;");

      // we create a list of Post objects from the database results
      foreach($req->fetchAll() as $client) {
        $list[] = new Client($client['id'],
                             $client['email'],
                             $client['vendorId'],
                             $client['createdAt'],
                             $client['updatedAt']);
      }

      return $list;
    }


    public static function find($client_id) {
      $db = Db::getInstance();
      // we make sure $id is an integer
      $id = intval($client_id);
      $req = $db->prepare('SELECT c.* FROM wp_clients c WHERE c.`client_id` = :id');
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('id' => $id));
      $client = $req->fetch();

      return new Client($client['id'], $client['email'], $client['vendorId'], $client['createdAt'], $client['updatedAt']);
    }
    
    public static function findByEmail($email){
        $db = Db::getInstance();
      // we make sure $id is an integer
    $validEmail = false;
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {//validate email address
        $validEmail = true;
      }
        
        if($validEmail){
          $req = $db->prepare('SELECT c.* FROM wp_clients c WHERE c.`email` = :email');
          // the query was prepared, now we replace :id with our actual $id value
          $req->execute(array('email' => $email));
          $client = $req->fetch();

          return new Client($client['id'], $client['email'], $client['vendorId'], $client['createdAt'], $client['updatedAt']);      
            
        }
        

      
    }
    
    /**
     * add client
     * @param {string} $email
     * @param {int} $vendorId
     * @return {object} $project
     * */
    public static function add($email, $vendorId){
        $db = Db::getInstance();
        $sql = "INSERT INTO `wp_clients`
                    (`email`, `vendorId`)
                VALUES
                    (:email,  :vendorId);";
        $req = $db -> prepare($sql);
        $arr_vars = array(
                        'email' => $email, 
                        'vendorId' => $vendorId
                    );
        $req -> execute($arr_vars);
        $lastId = $db -> lastInsertId();
        $client = self::find($lastId);

        return $client;
    }



}

?>