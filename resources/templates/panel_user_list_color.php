<?php
/**
 * Created by PhpStorm.
 * User: pauldixon
 * Date: 15/12/14
 * Time: 12:11
 */
if(!isset($_SESSION)){session_start();}


if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == ''))
{
    //header("location: login.html");
    //require_once(TEMPLATES_PATH . "/header_unregistered.php");
    ?>
    <div class="col-xs-1 col-md-1">
        <button type="button" class="btn btn-default btn-xs">
            <div class="thumbnail" style="background-color: #28a4c9"></div>
        </button>
    </div>
    <div class="col-xs-1 col-md-1">
        <button type="button" class="btn btn-default btn-xs">
            <div class="thumbnail" style="background-color: #28a4c9"></div>
        </button>
    </div>
    <div class="col-xs-1 col-md-1">
        <button type="button" class="btn btn-default btn-xs">
            <div class="thumbnail" style="background-color: #28a4c9"></div>
        </button>

    </div>

    <div class="row">
        <!-- COLOR -->
        <div class="col-xs-1 col-md-1">
            <button type="button" class="btn btn-default btn-xs">
                <div class="thumbnail" style="background-color: #28a4c9"></div>
            </button>
        </div>
        <div class="col-xs-1 col-md-1">
            <button type="button" class="btn btn-default btn-xs">
                <div class="thumbnail" style="background-color: #28a4c9"></div>
            </button>
        </div>
        <div class="col-xs-1 col-md-1">
            <button type="button" class="btn btn-default btn-xs">
                <div class="thumbnail" style="background-color: #28a4c9"></div>
            </button>
        </div>
    </div>
<?php

}
else
{
    require_once(realpath(dirname(__FILE__) . "/../config.php"));
    require_once(realpath(dirname(__FILE__) . "/../library/DB_manager.php"));
    $result = get_user_color(2,$_SESSION['sess_user_id']);
    if ($result->num_rows > 0)
    {
        $count = 0;
        // output data of each row
        while($row = $result->fetch_assoc())    //loop though row
        {
            if ($count == 0)
            {
                printf('<div class="row">' . "\n");
            }
            printf('<div class="col-xs-1 col-md-1">' . "\n");
            printf("\t" . '<button type="button" class="btn btn-default btn-xs">' . "\n");
            printf("\t\t" . '<div class="thumbnail" style="background-color:%s "></div>' . "\n",$row["item_descShort"]);
            printf("\t" . '</button>' . "\n");
            printf('</div>' . "\n");
            if ($count < 3)
            {
                $count++;


            }
            else
            {
                printf('</div>' . "\n");
                $count = 0;
            }
        }
        if ($count != 0)
        {
            printf('</div>' . "\n");
        }

    }
}
?>