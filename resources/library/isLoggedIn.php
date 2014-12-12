<?php
/**
 * Created by PhpStorm.
 * User: johan
 * Date: 12/11/2014
 * Time: 11:49 AM
 */
    if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')){
        echo 1;
    }
    else{
        echo 0;
    }

?>