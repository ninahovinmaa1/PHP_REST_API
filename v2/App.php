<?php 

//public 

class App {

  public static $errors = array();

  public static function main($data) {

    $limit = $_GET['show'] ?? null;
    $category =  ($_GET['category']) ?? null;
    $response = array();
    
    //category stuff
    if($category) {
      try {
          $response = self::finalGetDataByCategory($data, $category);
      } catch (Exception $error) {
          array_push(self::$errors, array("Category" => $error->getMessage()));
      }
    } else {
      $response = $data;
    }

    //if limit stuff
    if ($limit) {
      try {
          $response = self::finalGetDataByLimit($response, $limit);
      } catch (Exception $error) {
          array_push(self::$errors, array("Show" => $error->getMessage()));
      }

    } //else
      self::renderJson($response);
  }


  //randomize array
  public static function randomize($data) {
    shuffle($data);
    return $data;
  }

  public static function renderJson($array){
        if (self::$errors) {
            $json = json_encode(self::$errors, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            echo $json;
        } else {
            $json = json_encode($array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            echo $json;
        }
  }

  //get limit value or error
  public static function checkLimit($limit, $data){
    if ($limit > 20 || $limit < 1 ) {
      throw new Exception ("Show must be between 1 and 20");
    } else { 
      return $limit;

    }
  }

  public static function getProductsByLimit($limit, $array) {
    $setOfProducts = [];
    for ($i = 0; $i < $limit; $i++) {
        
        //random picked product index
        $j = rand(0, count($array) -1);
        array_push($setOfProducts, ($array[$j]));
    } 
    return $setOfProducts;
  }

  //returns null or category
  public static function checkCategory($category) {
    $allowedCategories = ['jewelery', 'men clothing', 'women clothing', null];

    if (!in_array($category, $allowedCategories)) {
        throw new Exception("Category not found");
    } else return $category;
  }

  public static function getCategory($category, $array) {
    $productsByCategory = [];
    $allowedCategories2 = ['jewelery', 'men clothing', 'women clothing'];
    //if category is correct, get products in that category
    if (in_array($category, $allowedCategories2)) {
        foreach ($array as $product) {
            if ($product['category'] == $category) {
                array_push($productsByCategory, $product);                  
            }
        }
        //checkLimit($limit, $productsByCategory);
        return $productsByCategory;
    } /* //else category is null, display all products
    else {
        return $array;
        //checkLimit($limit, $array);
    } */
  }

  public static function finalGetDataByLimit($data, $limit) {
          $randomizedData = self::randomize($data);
          $tempLimit = self::checkLimit($limit, $randomizedData);
          $setOfProducts = [];
          for ($i = 0; $i < $limit; $i++) {
            array_push($setOfProducts, ($randomizedData[$i]));
          } 
            return $setOfProducts;
  }

  public static function finalGetDataByCategory($data, $category) {
        self::checkCategory($category); //return null or category
        $setTwoOfProducts = self::getCategory($category, $data); //returns array with category, or all products
        return $setTwoOfProducts;
  }
}
