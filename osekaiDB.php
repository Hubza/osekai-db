<?php
class Database {

   private static $db;
   private $connection;

   private function __construct() {
       $this->connection = new MySQLi('localhost', 'user', 'password', 'database');
   }

   function __destruct() {
       $this->connection->close();
   }

   public static function getConnection() {
       if (self::$db == null) {
           self::$db = new Database();
       }
       return self::$db->connection;
   }

   /**
    * @param string $strQuery
    * @param string $strTypes
    * @param array $colVariables
    * 
    * @return array
    */
   public static function execSelect($strQuery, $strTypes, $colVariables) {
       $mysql = self::getConnection();
       $stmt = $mysql->prepare($strQuery);
       $stmt->bind_param($strTypes, ...$colVariables);
       $stmt->execute();
       $meta = $stmt->result_metadata(); 
        
       while ($field = $meta->fetch_field()) $params[] = &$row[$field->name];
       $stmt->bind_result(...$params);       
       while ($stmt->fetch()) {
           foreach($row as $key => $val) {
               $c[$key] = $val;
            }
            $hits[] = $c;
        }
        if($mysql->more_results()) {
            $mysql->next_result();
        }
        if(isset($hits)) {
            return $hits;
        } else {
            return [];
        }
        return (array)$hits;
   }

   /**
    * @param string $strQuery
    * 
    * @return array
    */
   public static function execSimpleSelect($strQuery) {
        $oQuery = self::getConnection()->query($strQuery);
        while ($val = $oQuery->fetch_assoc()) {
            $hits[] = $val;
        }
        return $hits;
    }

   /**
    * @param string $strQuery
    * @param string $strTypes
    * @param array $colVariables
    * 
    * @return void
    */
   public static function execOperation($strQuery, $strTypes, $colVariables): void {
       $mysql = self::getConnection();
       $stmt = $mysql->prepare($strQuery);
       $stmt->bind_param($strTypes, ...$colVariables);
       $stmt->execute();
   }

}
