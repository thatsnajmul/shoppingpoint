<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/../lib/Database.php');
    include_once ($filepath.'/../helpers/Format.php');
    
?>
<?php
    class Product{

        private $db;
        private $fm;
        
        public function __construct() {
            $this->db = new Database();
            $this->fm = new Format();
        }

        public function productInsert($data, $file){ 
            
            $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
            $catId = mysqli_real_escape_string($this->db->link, $data['catId']);
            $brandId = mysqli_real_escape_string($this->db->link, $data['brandId']);
            $body = mysqli_real_escape_string($this->db->link, $data['body']);
            $price = mysqli_real_escape_string($this->db->link, $data['price']);
            $type = mysqli_real_escape_string($this->db->link, $data['type']);

            $permited = array('jpg', 'jpeg', 'png', 'gif');
            $file_name = $file['image'] ['name'];
            $file_size = $file['image'] ['size'];
            $file_temp = $file['image'] ['tmp_name'];

            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
            $uploaded_image = "upload/".$unique_image;

            if ($productName == "" || $catId == "" || $brandId == "" || $body == "" || $price == "" || $file_name == "" || $type == "") {
                $msg = "<span class='error'>Fields Must Not be Empty.</span>";
                return $msg;
            } elseif ($file_size>1048567) {
                echo "<span class='error'>Image Size should be less the 1MB!</span>";
            } elseif (in_array($file_ext, $permited) === false) {
                echo "<span class='error'>You an upload only:-".implode(', ', $permited)."</span>";
            } else {
                move_uploaded_file($file_temp, $uploaded_image);
                $query = "INSERT INTO tbl_product(productName, catId, brandId, body, price, image, type) VALUES ('$productName','$catId','$brandId','$body','$price','$uploaded_image','$type')";
                $inserted_row = $this->db->insert($query);
                if ($inserted_row) {
                    $msg = "<span class='success'>Product Inserted Successfully.</span>";
                    return $msg;
                } else{
                    $msg = "<span class='error'>Product Not Inserted.</span>";
                    return $msg;
                }
            }

        }

        public function getAllProduct(){
            $query = "SELECT p.*, c.catName, b.brandName
                        FROM tbl_product as p, tbl_category as c, tbl_brand as b
                        WHERE p.catId = c.catId AND p.brandId = b.brandID
                        ORDER BY p.productId DESC";

            /*
            $query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName 
            FROM tbl_product
            INNER JOIN tbl_category
            ON tbl_product.catId = tbl_category.catId
            INNER JOIN tbl_brand
            ON tbl_product.brandId = tbl_brand.brandId
            ORDER BY tbl_product.productId DESC";
            */
            $result = $this->db->select($query);
            return $result;
        }

        public function getProById($id){
            $query  = "SELECT * FROM tbl_product WHERE productId = '$id'";
            $result = $this->db->select($query);
            return $result;
        }

        public function productUpdate($data, $file, $id){
            $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
            $catId = mysqli_real_escape_string($this->db->link, $data['catId']);
            $brandId = mysqli_real_escape_string($this->db->link, $data['brandId']);
            $body = mysqli_real_escape_string($this->db->link, $data['body']);
            $price = mysqli_real_escape_string($this->db->link, $data['price']);
            $type = mysqli_real_escape_string($this->db->link, $data['type']);

            $permited = array('jpg', 'jpeg', 'png', 'gif');
            $file_name = $file['image'] ['name'];
            $file_size = $file['image'] ['size'];
            $file_temp = $file['image'] ['tmp_name'];

            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
            $uploaded_image = "upload/".$unique_image;

            if ($productName == "" || $catId == "" || $brandId == "" || $body == "" || $price == "" || $type == "") {
                $msg = "<span class='error'>Fields Must Not be Empty.</span>";
                return $msg;
            } else {
                if (!empty($file_name)) {            
                        if ($file_size>1048567) {
                            echo "<span class='error'>Image Size should be less the 1MB!</span>";
                        } elseif (in_array($file_ext, $permited) === false) {
                            echo "<span class='error'>You an upload only:-".implode(', ', $permited)."</span>";
                        } else {
                            move_uploaded_file($file_temp, $uploaded_image);

                            $query = "INSERT INTO tbl_product(productName, catId, brandId, body, price, image, type) VALUES ('$productName','$catId','$brandId','$body','$price','$uploaded_image','$type')";
                            

                            $query = "UPDATE tbl_product
                                        SET
                                        productname = '$productName',
                                        catId       = '$catId',
                                        brandId     = '$brandId',
                                        body        = '$body',
                                        price       = '$price',
                                        image       = '$uploaded_image',
                                        type        = '$type'
                                        WHERE productId = '$id'";
                            $updated_row = $this->db->update($query);
                            if ($updated_row) {
                                $msg = "<span class='success'>Product Updated Successfully.</span>";
                                return $msg;
                            } else{
                                $msg = "<span class='error'>Product Not Updated.</span>";
                                return $msg;
                            }
                        } 
                    }else {

                        $query = "INSERT INTO tbl_product(productName, catId, brandId, body, price, image, type) VALUES ('$productName','$catId','$brandId','$body','$price','$uploaded_image','$type')";
                        

                        $query = "UPDATE tbl_product
                                    SET
                                    productname = '$productName',
                                    catId       = '$catId',
                                    brandId     = '$brandId',
                                    body        = '$body',
                                    price       = '$price',
                                    type        = '$type'
                                    WHERE productId = '$id'";
                        $updated_row = $this->db->update($query);
                        if ($updated_row) {
                            $msg = "<span class='success'>Product Updated Successfully.</span>";
                            return $msg;
                        } else{
                            $msg = "<span class='error'>Product Not Updated.</span>";
                            return $msg;
                        }
                        }
        }
        }


        public function delProById($id){
            $query = "SELECT * FROM tbl_product WHERE productId = '$id'";
            $getData = $this->db->select($query);
            if($getData) {
                while ($delImg = $getData->fetch_assoc()) {
                    $dellink = $delImg['image'];
                    unlink($dellink);
                }
            }

            $delquery = "DELETE FROM tbl_product WHERE productId = '$id'";
            $deldata = $this->db->delete($delquery);
            if ($deldata) {
                $msg = "<span class='success'>Product Deleted Successfully.</span>";
                        return $msg;
            } else {
                $msg = "<span class='error'>Product Not Deleted !</span>";
                        return $msg;
            }
        }
        public function getFeatureProduct(){
            $query  = "SELECT * FROM tbl_product WHERE type='0' ORDER BY productId DESC LIMIT 4";
            $result = $this->db->select($query);
            return $result; 
        }

        public function getNewProduct(){
            $query  = "SELECT * FROM tbl_product ORDER BY productId DESC LIMIT 4";
            $result = $this->db->select($query);
            return $result;
        }

        public function getSingleProduct($id){
            $query = "SELECT p.*, c.catName, b.brandName
                        FROM tbl_product as p, tbl_category as c, tbl_brand as b
                        WHERE p.catId = c.catId AND p.brandId = b.brandID AND p.productId = '$id'";
            $result = $this->db->select($query);
            return $result;
        }

        public function leatestFromIphone(){
            $query  = "SELECT * FROM tbl_product WHERE brandId = '2' ORDER BY productId DESC LIMIT 1";
            $result = $this->db->select($query);
            return $result; 
        }
        public function leatestFromSumsang(){
            $query  = "SELECT * FROM tbl_product WHERE brandId = '3' ORDER BY productId DESC LIMIT 1";
            $result = $this->db->select($query);
            return $result; 
        }
        public function leatestFromAcer(){
            $query  = "SELECT * FROM tbl_product WHERE brandId = '4' ORDER BY productId DESC LIMIT 1";
            $result = $this->db->select($query);
            return $result; 
        }
        public function leatestFromCanon(){
            $query  = "SELECT * FROM tbl_product WHERE brandId = '5' ORDER BY productId DESC LIMIT 1";
            $result = $this->db->select($query);
            return $result; 
        }

        public function productByCat($id){
            $catId = mysqli_real_escape_string($this->db->link, $id);
            $query  = "SELECT * FROM tbl_product WHERE catId = '$catId'";
            $result = $this->db->select($query);
            return $result; 
        }

        public function insertCompareData($cmrId, $cmprid){
            $cmrId = mysqli_real_escape_string($this->db->link, $cmrId);
            $productId = mysqli_real_escape_string($this->db->link, $cmprid);

            $query  = "SELECT * FROM tbl_product WHERE productId = '$productId'";
        $result = $this->db->select($query)->fetch_assoc();
        if ($result) {
                $productId = $result['productId'];
                $productName = $result['productName'];
                $price = $result['price'];
                $image = $result['image'];
            $query = "INSERT INTO tbl_compare(cmrId, productId, productName, price, image) VALUES ('$cmrId','$productId','$productName', '$price','$image')";
            $inserted_row = $this->db->insert($query);

            if ($inserted_row) {
                $msg = "<span class='success'>Added to Compare</span>";
                        return $msg;
            } else {
                $msg = "<span class='error'>Not Added !</span>";
                        return $msg;
            }

            }
        }
        
    }    
?>