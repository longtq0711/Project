<?php
require_once 'models/Model.php';
class Product extends Model {

  public function getProduct($params = []) {
    $str_filter = '';
    if (isset($params['category'])) {
      $str_category = $params['category'];
      $str_filter .= " AND categories.id IN $str_category";
    }
    if (isset($params['price'])) {
      $str_price = $params['price'];
      $str_filter .= " AND $str_price";
    }
    //do cả 2 bảng products và categories đều có trường name, nên cần phải thay đổi lại tên cột cho 1 trong 2 bảng
    $sql_select = "SELECT products.*, categories.name 
          AS category_name FROM products
          INNER JOIN categories ON products.category_id = categories.id
          WHERE products.status = 1 $str_filter";

    $obj_select = $this->connection->prepare($sql_select);
    $obj_select->execute();

    $products = $obj_select->fetchAll(PDO::FETCH_ASSOC);
    return $products;
  }
    public function getAllPagination($arr_params){
        $limit = $arr_params['limit'];
        $page = $arr_params['page'];
        $start = ($page - 1) * $limit;
        $str_filter = '';
        if (!empty($arr_params['price'])) {
            $str_price = $arr_params['price'];
            $str_filter .= " AND $str_price";
        }
        $obj_select = $this->connection->prepare("SELECT products.*, categories.name 
          AS category_name FROM products
          INNER JOIN categories ON products.category_id = categories.id
          WHERE products.status = 1 $str_filter LIMIT $start, $limit");
        $obj_select->execute();
        $products = $obj_select->fetchAll();
        return $products;
    }
  /**
   * Lấy thông tin sản phẩm theo id
   * @param $id
   * @return mixed
   */
  public function getById($id)
  {
    $obj_select = $this->connection
      ->prepare("SELECT products.*, categories.name AS category_name FROM products 
          INNER JOIN categories ON products.category_id = categories.id WHERE products.id = $id");

    $obj_select->execute();
    $product =  $obj_select->fetch(PDO::FETCH_ASSOC);
    return $product;
  }
    public function getPopular()
    {
        $obj_select = $this->connection
            ->prepare("SELECT products.*, categories.name AS category_name FROM products 
                        INNER JOIN categories ON categories.id = products.category_id
                        WHERE category_name LIKE 'Popular item'
                        ORDER BY products.created_at DESC
                        ");

        $arr_select = [];
        $obj_select->execute($arr_select);
        $popular = $obj_select->fetchAll(PDO::FETCH_ASSOC);

        return $popular;
    }
  public  function getProductByID($product_id){
      // - Tạo câu truy vấn
      $sql_select_one = "SELECT * FROM products WHERE id = $product_id";
      // - Tạo đối tượng truy vấn
      $obj_select_one = $this->connection->prepare($sql_select_one);
      // - Thực thi đối tượng truy vấn
      $obj_select_one->execute();
      // - Trả về mảng 1 phần tử duy nhất
      $product = $obj_select_one->fetch(PDO::FETCH_ASSOC);
      return $product;
  }
  public function countFilter($params){
      $str_filter = '';
      $str = $params['price'];
      $str_filter .= "AND $str";
      $obj_select = $this->connection->prepare("SELECT COUNT(id) FROM products WHERE products.status = 1 $str_filter");
      $obj_select->execute();
      return $obj_select->fetchColumn();
  }
  public function countTotal(){
      $obj_select = $this->connection->prepare("SELECT COUNT(id) FROM products");
      $obj_select->execute();
      return $obj_select->fetchColumn();
  }
    public function getProductFilter($params = []) {
        $limit = $params['limit'];
        $page = $params['page'];
        $start = ($page - 1) * $limit;
        $str_filter = '';
        if (isset($params['category'])) {
            $str_category = $params['category'];
            $str_filter .= " AND categories.id IN $str_category";
        }
        if (isset($params['price'])) {
            $str_price = $params['price'];
            $str_filter .= " AND $str_price";
        }
        //do cả 2 bảng products và categories đều có trường name, nên cần phải thay đổi lại tên cột cho 1 trong 2 bảng
        $sql_select = "SELECT products.*, categories.name 
          AS category_name FROM products
          INNER JOIN categories ON products.category_id = categories.id
          WHERE products.status = 1 $str_filter LIMIT $start, $limit";

        $obj_select = $this->connection->prepare($sql_select);
        $obj_select->execute();

        $products = $obj_select->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }
}

