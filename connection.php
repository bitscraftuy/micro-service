<?php
/***************************************************************
 * LETS INCLUDE LOCAL CONNECTION SETTINGS AND IF IT DOES NOT   *
 * EXISTS FAIL SILENTLY                                        *
 ***************************************************************/
  class Db {
    private static $instance = NULL;
    private static $settings = ['connection_string' => 'mysql:host=localhost;dbname=myDBName',
                                 'user'             => 'myUser',
                                 'password'         => 'myPass'];
 
    private function __construct() {}

    private function __clone() {}

    public static function setSettings($key, $value) {
        self::$settings[$key] = $value;
    }

    public static function getInstance() {
      if (!isset(self::$instance)) {
        $pdo_options =  [
                          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                          PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                        ];
        self::$instance = new PDO(self::$settings['connection_string'], self::$settings['user'], self::$settings['password'], $pdo_options);
      }
      return self::$instance;
    }
  }

/***************************************************************
 * LETS INCLUDE LOCAL CONNECTION SETTINGS AND IF IT DOES NOT   *
 * EXISTS FAIL SILENTLY                                        *
 ***************************************************************/
$display_errors = ini_get("display_errors"); ini_set("display_errors", 0);
if(file_exists ('local-connection.php'))
  include('local-connection.php');
ini_set("display_errors", $display_errors);
/*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*
 | SAMPLE CONTENT FOR local-connection.php FILE: 
 *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*/
//if(class_exists('Db')){
//  Db::setSettings('connection_string', 'mysql:host=localhost;dbname=dbnamehere');
//  Db::setSettings('user', 'root');
//  Db::setSettings('password', 'root');
//}

?>