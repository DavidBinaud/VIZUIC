<?php

require_once File::build_path(array("config", "Conf.php"));

class Model {
  public static $pdo;
  private static $prefixe_table = "VIZUIC2_";
   
  static public function Init() {

    $hostname = Conf::getHostname();
    $database = Conf::getDatabase();

    try {
      // Connexion à la base de données            
      // Le dernier argument sert à ce que toutes les chaines de caractères 
      // en entrée et sortie de MySql soit dans le codage UTF-8
      self::$pdo = new PDO("mysql:host=$hostname;dbname=$database", Conf::getLogin(), Conf::getPassword(),
                           array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
         
      // On active le mode d'affichage des erreurs, et le lancement d'exception en cas d'erreur
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
      if (Conf::getDebug()) {
        echo $e->getMessage(); // affiche un message d'erreur
      } else {
        echo 'Une erreur est survenue <a href=""> retour a la page d\'accueil </a>';
      }
      die();
    }
  }

  public static function selectAll() {
    $table_name = self::$prefixe_table . static::$object;

    $class_name = "Model" . ucfirst(static::$object);

    $rep = Model::$pdo->query("SELECT * FROM {$table_name}");
      
    $rep->setFetchMode(PDO::FETCH_CLASS, $class_name);
      
    return $rep->fetchAll();
  }

  public static function select($primary_value) {
    $table_name = self::$prefixe_table . static::$object;

    $class_name = "Model" . ucfirst(static::$object);

    $primary_key = static::$primary;

    $sql = "SELECT * from $table_name WHERE $primary_key = :primary";
    // Préparation de la requête
    $req_prep = Model::$pdo->prepare($sql);

    $values = array("primary" => $primary_value);

    $req_prep->execute($values);

    $req_prep->setFetchMode(PDO::FETCH_CLASS, $class_name);
    
    $tab = $req_prep->fetchAll();
    // Attention, si il n'y a pas de résultats, on renvoie false
    if (empty($tab))
        return false;
    return $tab[0];
  }

  public static function delete($primary_value) {
    $table_name = self::$prefixe_table . static::$object;

    $class_name = "Model" . ucfirst(static::$object);

    $primary_key = static::$primary;

    $sql = "DELETE FROM $table_name WHERE $primary_key = :primary";

    $req_prep = Model::$pdo->prepare($sql);

    $values = array("primary" => $primary_value);

    $req_prep->execute($values);
  }

  public static function update($data) {
    $table_name = self::$prefixe_table . static::$object;

    $class_name = "Model" . ucfirst(static::$object);

    $primary_key = static::$primary;

    $value2 = "";

    foreach ($data as $key => $value) {
      if (isset($key))
        $value2 = $value2 . $key . "= :" . $key . ", ";
    }

    $value2 = rtrim($value2, ", ");

    $sql = "UPDATE $table_name SET $value2
            WHERE $primary_key = :$primary_key";

    $req_prep = Model::$pdo->prepare($sql);

    $req_prep->execute($data);
  }

  public static function save($data) {
    $table_name = self::$prefixe_table . static::$object;

    $class_name = "Model" . ucfirst(static::$object);

    $primary_key = static::$primary;

    $value1 = "";
    $value2 = "";

    foreach ($data as $key => $value) {
      $value1 = $value1 . $key . ", ";
      $value2 = $value2 . " :" . $key . ", ";
    }

    $value1 = rtrim($value1, ", ");

    $value2 = rtrim($value2, ", ");

        $sql = "INSERT INTO $table_name($value1) VALUES ($value2)";

        $req_prep = Model::$pdo->prepare($sql);
        
      try{
        $req_prep->execute($data);
      }
      catch(PDOException $e) {
        if($e->getCode() == 23000) {
          return false;
        }
      }
      return true;
    }
}
Model::Init();
?>