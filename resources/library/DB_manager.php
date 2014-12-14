<?php
// load config file
require_once(realpath(dirname(__FILE__) . "/../config.php"));

//global sql databse connection
$mysqlCon;

//print debug logg , on or off.
$printLog = 0;
$printLogString = "";
$printLogString .= "entered manage_db file"."<br>\n";




if(isset($_POST['action']) && !empty($_POST['action']))
{
    $action = $_POST['action'];


        $printLogString .= "entered POST request handler! with action: " . $action . "\n";


    init_DB();

    $ajax= 1;

    switch($action) {
        case 'set_logout'               : set_logout($ajax);break;
        case 'get_login'                : get_login($ajax);break;
        case 'get_users'                : get_users($ajax);break;
        case 'get_user'                 : get_user($ajax,$_POST['user_id']);break;
        case 'get_items'                : get_items($ajax);break;
        case 'get_item'                 : get_item($ajax,$_POST['item_id']);break;
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
        case 'insert_order_detail'      : insert_order_detail();break;

        case 'delete_by_id'             : delete_by_id();break;

        case 'bind_itemCategory'        : bind_itemCategory();break;

        case 'accept_shoppingCart'        : accept_shoppingCart($ajax);break;
        default:
            $printLogString .= " action not recognised <br>\n";
            break;

    }
}
else
{
    $printLogString .= "form action not set  <br>\n";
}

if($printLog) {
    echo $printLogString;
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
function set_logout($ajax)
{
    // echo "set_logout";
    // http://php.net/session_destroy
// Initialize the session.
// If you are using session_name("something"), don't forget it now!

  //  session_start();
    if(!isset($_SESSION)){session_start();} // double check session start that conforms with one.com php

// Unset all of the session variables.
    $_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

// Finally, destroy the session.
    session_destroy();
    $xml = "<?xml version='1.0' encoding='utf-8'?>\n";
    $xml .= "<logout>true</logout>";

    if($ajax){
        echo $xml;
    }
    else{
        return $xml;
    }
}

function  accept_shoppingCart($ajax)
{
    //check if logged in!
    if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')){

        $rootElementName = "loginUsers";
        $childElementName="loginUser";
        $checkthisIs = $_SESSION['sess_user_id'];
        //get user details for creating order
        $userData = get_user(0,$_SESSION['sess_user_id']);
        $xml = sqlToXml($userData,$rootElementName, $childElementName);
        $xmlObj = new SimpleXMLElement($xml);

        //insert user details to order and save order.
        foreach ($xmlObj->loginUser as $user)    //loop though row
        {
            $uid     = (string)$user->user_id;
            $ufname  = (string)$user->user_firstName;
            $ulname  = (string)$user->user_lastName;
            $uemail     = (string)$user->user_email;
            $uadress  = (string)$user->user_address;
            $uzip  = (string)$user->user_zip;
            $ucity     = (string)$user->user_city;
            $ucountry  = (string)$user->user_country;

        }
                          /*
                          order_shipping,
                          order_phone,
                          order_tax,
                          order_date,
                          order_paymentID,
                          order_transactStatus,
                          order_shipped,
                          order_fulFilled,
                          */

        $query = "INSERT INTO orders(
                          order_ShipName,
                          order_ShipAddress,
                          order_email,
                          order_shipZip,
                          order_shipCity,
                          order_shipCountry,
                          user_id
                          )
                       VALUES('"
                .$ufname.$ulname."','"
                .$uadress."','"
                .$uemail."','"
                .$uzip ."','"
                .$ucity."','"
                .$ucountry ."','"
                .$uid
                ."')";

        query_insert($query);

        //return the created order as xml
        $rootElementName = "UserOrders";
        $childElementName="order";

        $userCurrentOrder = get_user_currentOrder(0,$_SESSION['sess_user_id']);
        $userCurrentOrder_xml = sqlToXml($userCurrentOrder,$rootElementName, $childElementName);

        if($ajax){
            echo $userCurrentOrder_xml;
        }
        else{
            return $userCurrentOrder_xml;
        }

    }
}

//----GETTERS----

function get_login($ajax)
{
    //session_destroy();
    $rootElementName = "loginUsers";
    $childElementName="loginUser";

    // build query
    global $config;
    $username = $_POST['username'];
    $password = $_POST['password'];
   // $username = $mysqli->real_escape_string($username);
    // $password = $mysqli->real_escape_string($password);

    $query = ("SELECT user_id, user_firstName, user_lastName, user_regDate
                FROM users
                WHERE user_email = '" . $username . "' AND user_password = '" . $password ."'");
    $result = query_get($query);

    $xml = sqlToXml($result,$rootElementName, $childElementName);

    if ($result->num_rows == 1)
    {
        $xmlObj = new SimpleXMLElement($xml);


        if(!isset($_SESSION)){session_start();}
        $_SESSION['valid'] = 'valid';
        if($_SESSION['valid'] != 'valid')
        {
            //handle disabled sessions
        }

        // output data of each row
        foreach ($xmlObj->loginUser as $user)    //loop though row
        {
            $id     = (string)$user->user_id;
            $fname  = (string)$user->user_firstName;
            $lname  = (string)$user->user_lastName;

            // store user ID
            session_regenerate_id();
            $_SESSION['sess_user_id'] = $id;
            $_SESSION['sess_username'] = $fname . " " . $lname;

            //close off database and sessionwrite;
            session_write_close();

        }
     }

    // query data from database


    //convert query to xml
     //echo $xml;
    if($ajax){
        echo $xml;
    }
    else{
        return $xml;
    }
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
    //$query = "SELECT * FROM itemCategories, items WHERE category_id =". $category_id .";

    if (is_array($category_id))
    {
        if(count($category_id)<1)
        {
            return;
        }
        $queryWhere= " WHERE itemCategories.category_id = $category_id[0]";
        for($i=1; $i<count($category_id);$i++)
        {
            $queryWhere.=" or itemCategories.category_id = $category_id[$i] ";
        }
    }
    else
    {
        $queryWhere= " WHERE itemCategories.category_id = $category_id";
    }


    $query = ("
        SELECT
            itemCategories.*,
            items.*
         FROM  itemCategories
         INNER JOIN items ON (items.item_id = itemCategories.item_id)").$queryWhere;



    // query data from database
    $result = query_get($query);

    //convert query to xml
    $xml = sqlToXml($result,$rootElementName, $childElementName);
    //return data
    if($ajax){
        header("Content-Type: text/xml; charset=utf-8");
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
function get_item($ajax, $itemId){

    $rootElementName = "items";
    $childElementName="item";

    // build query
    $query = "SELECT * FROM items WHERE item_id = ".$itemId;

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
function get_user_currentOrder($ajax,$user_id){

    $rootElementName = "orders";
    $childElementName= "order";

    // build query
    $query = "SELECT * FROM orders where user_id=".$user_id AND order_fulFilled!=1;

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

function insert_order_detail(){
    echo "entered insert order detail";
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
    //header("Content-Type: text/xml; charset=utf-8");
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
        $xml .=  "</" . $rootElementName . ">";
    }
    return $xml;
}