<?php
require_once(realpath(dirname(__FILE__) . "/../library/DB_manager.php"));
if(!isset($_SESSION)){
    session_start();
}
//std tool set
$arr = array ('std_1'=>"drawing_line_2px",
                'std_2'=>"drawing_line_4px",
                'std_3'=>"drawing_line_8px");


$userItems = get_user_tool(0,$_SESSION['sess_user_id']);
$userItemsOBJ = new SimpleXMLElement($userItems);

    $count = 0;
    // output data of each row
    foreach ($userItemsOBJ as $item)    //loop though row
    {
        if($item->item_code!= null) {
            $arr[(int)$item->item_id] = (string)$item->item_code;
        }
        else{
            $arr[$item->item_id] = "null";
        }

}

echo json_encode($arr);

?>