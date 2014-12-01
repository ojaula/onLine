<?php


// load config file
require_once(realpath(dirname(__FILE__) . "/../config.php"));

//global sql databse connection
$mysqlCon;

//print debug logg , on or off.
$printLog = 0;

if($printLog){
    echo "entered manage_db file"."\n";
}



if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];

    if($printLog) {
        echo "entered POST request handler! with action: " . $action . "\n";
    }

    init_DB();

    $ajax= 1;

    switch($action) {
        case 'get_login'                : get_login();break;
        case 'get_users'                : get_users($ajax);break;
        case 'get_user'                 : get_user($ajax,$_POST['user_id']);break;
        case 'get_items'                : get_items($ajax);break;
        case 'get_categories'           : get_categories($ajax);break;
        case 'get_item_category'        : get_item_category($ajax,$_POST['item_id']);break;
        case 'get_category_items'       : get_category_items($ajax,$_POST['category_id']);break;
        case 'get_user_items'           : get_user_items($ajax,$_POST['user_id']);break;
        case 'get_user_missingItems'    : get_user_missingItems($ajax,$_POST['user_id']);break;
        case 'get_user_orders'          : get_user_orders($ajax,$_POST['user_id']);break;
        case 'get_order_orderDetails'   : get_order_orderDetails($ajax,$_POST['order_id']);break;

        case 'insert_user'              : insert_user();break;
        case 'insert_item_color'        : insert_item_color($_POST['color']);break;
        case 'insert_item'              : insert_item();break;
        case 'insert_category'          : insert_category();break;

        case 'delete_by_id'             : delete_by_id();break;

        case 'bind_itemCategory'        : bind_itemCategory();break;

    }
}

 

function init_DB(){

    global $config;
    global $mysqlCon;
    //init database obj

    $DB_USERNAME    = $config["db"]["onlineDB"]["username"];
    $DB_PASSWORD    = $config["db"]["onlineDB"]["password"];
    $DB_SERVERNAME  = $config["db"]["onlineDB"]["host"];

// Create connection
    $mysqlCon = new mysqli($DB_SERVERNAME, $DB_USERNAME, $DB_PASSWORD);
}

//----GETTERS----

function get_login()
{
    $rootElementName = "users";
    $childElementName="user";

    // build query
    global $config;
    $username = $_POST['username'];
    $password = $_POST['password'];
   // $username = $mysqli->real_escape_string($username);
    // $password = $mysqli->real_escape_string($password);

    $query = ("SELECT UserID, UserFirstName, UserLastName, UserRegDate FROM Users WHERE UserEmail = '" . $username . "' AND UserPassword = '" . $password ."'");
    $result = query_get($query);
    $returnValue = query_get($query)->fetch_assoc();

    if( count($returnValue) ) {
        echo " <h1>user found</h1>";
        echo $returnValue["UserLastName"];
        require_once(TEMPLATES_PATH . "/header_hasLoggedin.php");
        //resources/templates/header_hasLoggedin.php
    }
    else
    {
        echo "error";
    }
    // query data from database
   

    //convert query to xml
    //$xml = sqlToXml($result,$rootElementName, $childElementName);
    $xml = sqlToXml($result,$rootElementName, $childElementName);
    //return data
    echo $xml;
}



function get_user($ajax,$user_id){

    $rootElementName = "users";
    $childElementName="user";

    // build query
    $query = "SELECT * FROM users where user_id=".$user_id ;

    // query data from database
    $result = query_get($query);

    //convert query to xml
    //$xml = sqlToXml($result,$rootElementName, $childElementName);
    $xml = sqlToXml($result,$rootElementName, $childElementName);
    //return data
    if($ajax){
        echo $xml;
    }
    else{
        return $xml;
    }

}

function get_item_category($ajax,$item_id){

    $rootElementName = "items";
    $childElementName="item";

    // build query
    $query = "SELECT * FROM categories WHERE item_id =". $item_id ;

    // query data from database
    $result = query_get($query);

    //convert query to xml
    //$xml = sqlToXml($result,$rootElementName, $childElementName);
    $xml = sqlToXml($result,$rootElementName, $childElementName);
    //return data
    if($ajax){
        echo $xml;
    }
    else{
        return $xml;
    }

}

function get_categories($ajax){

    init_DB();

    $rootElementName ="categories";
    $childElementName="category";

    // build query
    $query = "SELECT * FROM categories";

    // query data from database
    $result = query_get($query);

    //convert query to xml
    $xml = sqlToXml($result,$rootElementName, $childElementName);
    //return data
    if($ajax){
        echo $xml;
    }
    else{
        return $xml;
    }

}

function get_category_items($ajax,$category_id){

    $rootElementName = "category";
    $childElementName="item";

    // build query
    $query = "SELECT * FROM itemCategories WHERE category_id =". $category_id ;

    // query data from database
    $result = query_get($query);

    //convert query to xml
    $xml = sqlToXml($result,$rootElementName, $childElementName);
    //return data
    if($ajax){
        echo $xml;
    }
    else{
        return $xml;
    }

}

function get_items($ajax){

    $rootElementName = "items";
    $childElementName="item";

    // build query
    $query = "SELECT * FROM items";

    // query data from database
    $result = query_get($query);

    //convert query to xml
    $xml = sqlToXml($result,$rootElementName, $childElementName);
    //return data
    if($ajax){
        echo $xml;
    }
    else{
        return $xml;
    }

}

function get_users($ajax){

    $rootElementName = "users";
    $childElementName="user";

    // build query
    $query = "SELECT * FROM users" ;

    // query data from database
    $result = query_get($query);

    //convert query to xml
    $xml = sqlToXml($result,$rootElementName, $childElementName);
    //return data
    if($ajax){
        echo $xml;
    }
    else{
        return $xml;
    }

}

function get_user_items($ajax,$user_id){

    $rootElementName = "user_items";
    $childElementName="user_item";

    // build query
    $query = "SELECT * FROM userItems where user_id=".$user_id ;

    // query data from database
    $result = query_get($query);

    //convert query to xml
    $xml = sqlToXml($result,$rootElementName, $childElementName);
    //return data
    if($ajax){
        echo $xml;
    }
    else{
        return $xml;
    }

}

function get_user_missingItems($ajax,$user_id){

    $rootElementName = "missingitems";
    $childElementName="missingitem";

    // build query
    $query = "SELECT * FROM userItems where user_id!=".$user_id ;

    // query data from database
    $result = query_get($query);

    //convert query to xml
    $xml = sqlToXml($result,$rootElementName, $childElementName);
    //return data
    if($ajax){
        echo $xml;
    }
    else{
        return $xml;
    }

}

function get_user_orders($ajax,$user_id){

    $rootElementName = "orders";
    $childElementName= "order";

    // build query
    $query = "SELECT * FROM orders where user_id=".$user_id ;

    // query data from database
    $result = query_get($query);

    //convert query to xml
    $xml = sqlToXml($result,$rootElementName, $childElementName);
    //return data
    if($ajax){
        echo $xml;
    }
    else{
        return $xml;
    }

}

function get_order_orderDetails($ajax,$order_id){

    $rootElementName = "orderDetails";
    $childElementName= "orderDetail";

    // build query
    $query = "SELECT * FROM orderDetails where order_id=".$order_id ;

    // query data from database
    $result = query_get($query);

    //convert query to xml
    $xml = sqlToXml($result,$rootElementName, $childElementName);

    //return data
    if($ajax){
        echo $xml;
    }
    else{
        return $xml;
    }

}


//----SETTERS----

function insert_user(){

    $query = "INSERT INTO users(
                              user_firstName,
                              user_lastName,
                              user_password,
                              user_email,
                              user_phone,
                              user_address,
                              user_zip,
                              user_city,
                              user_verificationCode,
                              user_country,
                              user_regDate,
                              user_emailVerified
                              )
                           VALUES('"
                                    .$_POST['firstName']."','"
                                    .$_POST['lastName']."','"
                                    .$_POST['password']."','"
                                    .$_POST['email']."','"
                                    .$_POST['phone']."','"
                                    .$_POST['address']."','"
                                    .$_POST['zip']."','"
                                    .$_POST['city']."','"
                                    .$_POST['verificationCode']."','"
                                    .$_POST['country']."','"
                                    .$_POST['regDate']."','"
                                    .$_POST['emailVerified']
                                    ."')";

    query_insert($query);

}
// this is an safety check for color items, using insert_item.
function insert_item_color($color){
    global $config;

    //split color value to r g b.
    $r = hexdec(substr($color,1,2)); // start + length of substring
    $g = hexdec(substr($color,3,2));
    $b = hexdec(substr($color,5,2));

    //get config color restraints
    $is_r = $config["available_colors"]["r"];
    $is_g = $config["available_colors"]["g"];
    $is_b = $config["available_colors"]["b"];
    $color_max = $config["available_colors"]["value_max"];
    $color_min = $config["available_colors"]["value_min"];
    $color_res = $config["available_colors"]["value_stepSize"];

    //check color values to constraints
    if(!$is_r or $r < $color_min or  $r > $color_max or ($r%$color_res)!=0){
        return;
    }
    if(!$is_g or $g < $color_min or  $g > $color_max or ($g%$color_res)!=0){
        return;
    }
    if(!$is_b or $b < $color_min or  $b > $color_max or ($b%$color_res)!=0){
        return;
    }

    //insert item
    insert_item();
}

function insert_item(){

        $query = "INSERT INTO items(
                              item_name,
                              item_price,
                              item_weight,
                              item_descShort,
                              item_descLong,
                              item_image,
                              item_update,
                              item_stock,
                              item_rank,
                              item_color
                              )
                           VALUES('".$_POST['name']."','"
                                    .$_POST['price']."','"
                                    .$_POST['weight']."','"
                                    .$_POST['descShort']."','"
                                    .$_POST['descLong']."','"
                                    .$_POST['image']."','"
                                    .$_POST['update']."','"
                                    .$_POST['stock']."','"
                                    .$_POST['rank']."','"
                                    .$_POST['color']
                                    ."')";

         query_insert($query);



}

function insert_category(){
    $query = "INSERT INTO categories(
                              category_name,
                              category_image
                              )
                           VALUES('".$_POST['name']."','"
                                    .$_POST['image']
                                    ."')";

    query_insert($query);

}

function bind_itemCategory()
{
    $query = "INSERT INTO itemCategories(
                              item_id,
                              category_id
                              )
                           VALUES('". $_POST['item_id'] . "','"
                                    . $_POST['category_id']
                                    . "')";


    query_insert($query);

}

//----DELETE-----
function delete_by_id(){
    // sql to delete a record
    $tn =$_POST['tableName'];

    $query="temp";

    switch($tn){
        case 'items' :
            $query = "DELETE FROM ".$_POST['tableName']."  WHERE item_id        =". $_POST['id'];
            ;break;
        case 'users' :
            $query = "DELETE FROM ".$_POST['tableName']."  WHERE user_id       =". $_POST['id'];
            ;break;
        case 'userItems' :
            $query = "DELETE FROM ".$_POST['tableName']."  WHERE userItem_id    =". $_POST['id'];
            ;break;
        case 'itemModifiers' :
            $query = "DELETE FROM ".$_POST['tableName']."  WHERE itemModifier_id  =". $_POST['id'];
            ;break;
        case 'modifiers' :
            $query = "DELETE FROM ".$_POST['tableName']."  WHERE modifier_id  =". $_POST['id'];
            ;break;
        case 'itemCategories' :
            $query = "DELETE FROM ".$_POST['tableName']."  WHERE itemCategory_id  =". $_POST['id'];
            ;break;
        case 'categories' :
            $query = "DELETE FROM ".$_POST['tableName']."  WHERE category_id  =". $_POST['id'];
            ;break;
        case 'orders' :
            $query = "DELETE FROM ".$_POST['tableName']."  WHERE order_id  =". $_POST['id'];
            ;break;
        case 'ordersDetails' :
            $query = "DELETE FROM ".$_POST['tableName']."  WHERE orderDetail_id  =". $_POST['id'];
            ;break;

    }

    //perform action
    query_insert($query);
}

//----Generic query methods----
// Two query functions for insert and get, for easier to read code.
function query_insert($query){
    global $config;
    global $mysqlCon;
    global $printLog;// get global print state


    // Check connection
    if ($mysqlCon->connect_error) {
        die("Connection failed: " . $mysqlCon->connect_error);
    }
    echo "\n"."Connected successfully";

    //select database
    $DB_NAME = $config["db"]["onlineDB"]["dbname"];
    $mysqlCon->select_db($DB_NAME);

    //insert row to database
    if ($mysqlCon->query($query) === TRUE) {
        echo "\n"."New record created successfully";
    } else {
        echo "\n"."Error: " . $query . "\n" . $mysqlCon->error;
    }

    $mysqlCon->close();
}

function query_get($query){

    global $config;
    global $mysqlCon;
    global $printLog;// get global print state

    $DB_NAME        = $config["db"]["onlineDB"]["dbname"];
    // Check connection
    if ($mysqlCon->connect_error) {
        die("Connection failed: " .$mysqlCon ->connect_error);
    }
    if($printLog) {
        echo "\n" . "Connected successfully";
    }
    //select database
    $mysqlCon->select_db($DB_NAME);

    //search db from query
    $result = $mysqlCon->query($query);

    $mysqlCon->close();

    return $result;
}


//convert mysql query to xml string
function sqlToXml($result, $rootElementName, $childElementName)
{
    header("Content-Type: text/xml; charset=utf-8");
    $xml = "<?xml version='1.0' encoding='utf-8'?>\n";
    $xml .=  "<" . $rootElementName . ">"."\n";

    if ($result->num_rows > 0)
    {
        // output data of each row
        while($row = $result->fetch_assoc())    //loop though row
        {
            $xml .= "<" . $childElementName . ">"."\n";
            foreach($row as $field=>$value)     //loop though columns
            {
                $xml .= "<" . $field . ">";
                $xml .= $value;
                $xml .= "</" . $field . ">"."\n";
            }
            $xml .= "</" . $childElementName . ">"."\n";
        }
        $xml .=  "</" . $rootElementName . ">";
    }
    else
    {
        return "0 results";
    }
    return $xml;
}