<?php
if(!isset($_SESSION)){session_start();}

/*
 * <div class="col-xs-2 col-md-2">
                            <button type="button" class="btn btn-default btn-xs glyphicon glyphicon-pencil">8px
                            </button>

                        </div>


 */

//echo std brushes
echo     '<!-- BRUSHES CONTENT -->
        <div class="col-xs-3 col-md-3">
            <button type="button" onclick="set_canvas_context({tool:\'std_1\'})" class="btn btn-default btn-xs glyphicon glyphicon-pencil">2px</button>
        </div>
        <div class="col-xs-3 col-md-3">
            <button type="button" onclick="set_canvas_context({tool:\'std_2\'})" class="btn btn-default btn-xs glyphicon glyphicon-pencil">4px</button>
        </div>
        <div class="col-xs-3 col-md-3">
            <button type="button" onclick="set_canvas_context({tool:\'std_3\'})" class="btn btn-default btn-xs glyphicon glyphicon-pencil">8px</button>

        </div>';



if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == ''))
{

}
else
{
    require_once(realpath(dirname(__FILE__) . "/../config.php"));
    require_once(realpath(dirname(__FILE__) . "/../library/DB_manager.php"));

    $result = get_user_tool(2,$_SESSION['sess_user_id']);
    if ($result->num_rows > 0)
    {
        $count = 0;
        // output data of each row
        while($row = $result->fetch_assoc())    //loop though row
        {

            printf('<div class="col-xs-3 col-md-3">' . "\n");

            printf("\t" . '<button type="button" onclick="set_canvas_context({tool:\''.$row["item_id"].'\'})" class="btn btn-default btn-xs glyphicon glyphicon-pencil">%s</button>' . "\n",$row["item_name"]);
            printf('</div>' . "\n");

        }


    }

}

?>