<?php
class Vendor {
    public $id;
    public $name;
    public $email;
    public $createdAt;
    public $updatedAt;
    public $defaultVendor;

  	public function __construct($id = NULL, $name = '', $email = '', $createdAt = '', $updatedAt = '',$defaultVendor = 0) {
     	  $this->id         = $id;
          $this->name       = $name;
          $this->email      = $email;
          $this->createdAt  = $createdAt;
          $this->updatedAt  = $updatedAt;
            $this->defaultVendor  = $defaultVendor;
    }


    public static function all(){
      $list = [];
      $db = Db::getInstance();

      $req = $db->query("SELECT v.* FROM wp_vendors v;");

      // we create a list of Post objects from the database results
      foreach($req->fetchAll() as $vendor) {
        $list[] = new Vendor($vendor['id'],
                             $vendor['name'],
                             $vendor['email'],
                             $vendor['createdAt'],
                             $vendor['updatedAt'],
                            $vendor['defaultVendor']);
      }

      return $list;
    }


    public static function find($vendor_id) {
      $db = Db::getInstance();
      // we make sure $id is an integer
      $id = intval($vendor_id);
      $req = $db->prepare('SELECT v.* FROM wp_vendors v WHERE v.`id` = :id');
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('id' => $id));
      $vendor = $req->fetch();

      return new Vendor($vendor['id'], $vendor['name'], $vendor['email'], $vendor['createdAt'], $vendor['updatedAt'],$vendor['defaultVendor']);
    }
    
    public static function findDefaultVendor(){
        $db = Db::getInstance();
      // we make sure $id is an integer
      $defaultVendor = 1;
      $req = $db->prepare('SELECT v.* FROM wp_vendors v WHERE v.`defaultVendor` = :defaultVendor');
      // the query was prepared, now we replace :id with our actual $id value
      $req->execute(array('defaultVendor' => $defaultVendor));
      $vendor = $req->fetch();

      return new Vendor($vendor['id'], $vendor['name'], $vendor['email'], $vendor['createdAt'], $vendor['updatedAt'],$vendor['defaultVendor']);
    }



}

?>