<?php

global $sub_comment;
global $base_comments;
global $comments;
global $i;

/**
 * Created by PhpStorm.
 * User: Johan
 * Date: 12/30/2014
 * Time: 10:17 AM
 */
//require("/../library/DB_manager.php");
require_once(realpath(dirname(__FILE__) . "/../library/DB_manager.php"));
if(!isset($_SESSION)){
    session_start();
}
// is logged in?
if(isset($_SESSION['sess_user_id']))
{
    $userId = $_SESSION['sess_user_id'];
    $itemid = $_POST['item_id'];
    $gradeXml = get_item_grade(0,$itemid);
    $gradexmlOBJ = new SimpleXMLElement($gradeXml);

    $gradeValue=0;
    $i=0;
    $comments = "";
    echo "<div class='col-xs-12 col-md-6' >";
    echo "</div>";

    echo "<div class='col-xs-12 col-md-6' style='overflow-y: scroll; min-height:300px; border-left: 1px gray solid;' >";
    foreach($gradexmlOBJ as $grade)
    {
        // calculate grade if 1-10, 0 is default comment and not rating
        if($grade->itemGrade_nr!=0) {
            $gradeValue += $grade->itemGrade_nr;
            $i += 1;
        }

    }
    if($i!=0){
        $gradeValue /=$i;
    }
    else{
        $gradeValue = "-";
    }
    echo  "<span style='font-size:30;'> Rating | ". $gradeValue."/10</span>";

    prepareCommentTree($itemid);
    //echo $comments;
    //enter comment form, if itemgrade_parent = 0, -> is comment to item and not an nested comment..
    echo "<div style='boarder:1px gray solid;'>
        <hr>
        <form class='commentForm' oninput='amount.value=rangeInput.value'>
            <input type='hidden' name='action' value='insert_item_grade'>
            <input type='hidden' name='itemGrade_parent' value='0'>
            <input type='hidden' name='item_id' value=".$itemid.">
            Rate item <output style='display:inline-block;' name='amount' for='rangeInput'>6</output>/10
            <input id='rangeInput' name='itemGrade_nr' type='range' min='1' max='10' />
            Comment:
            <textarea name='itemGrade_comment' style='width:100%; height:100px;'></textarea>
            <button type='button' class='btn btn-info' onclick='addComment(\"commentForm\",".$itemid.")'>Submit
        </form>
    </div>";

    echo "</div>";

}
function prepareCommentTree($itemid){
    global $sub_comment;
    $sub_comment= array();
    global $base_comments;
    $base_comments = array();
    global $comments;
    $comments="";
    global $i;
    $i=0;

    $gradeXml = get_item_grade(0,$itemid);
    $gradexmlOBJ = new SimpleXMLElement($gradeXml);
    foreach($gradexmlOBJ as $grade){
        if ($grade->itemGrade_parent!="0"){
            // add sub comment to parent id, if array exist append, if not create new.
            if(isset($sub_comment[(int)$grade->itemGrade_parent])){
                array_push($sub_comment[(int)$grade->itemGrade_parent], $grade);
            }
            else{
                $sub_comment[(int)$grade->itemGrade_parent] = array($grade);
            }
        }
        else{
            //add base comment/ comment with no parent
            $base_comments[$i]=$grade;
            $i+=1;
        }

    }
    foreach($base_comments as $basecomment){
        $comments .= "<hr style='margin-top:3px; margin-bottom:3px;'><strong>" . $basecomment->user_firstName . "</strong> <span style='font-size:30;'>" . $basecomment->itemGrade_nr . "/10</span>";
        $comments .= "<br> Says <br> <p>". $basecomment->itemGrade_comment."</p> <div style='margin-left:25px; padding-left:5px; border-left:1px gray solid;'> ";

        buildCommentTree($basecomment);

        $comments .= "<hr style='margin-top:3px; margin-bottom:3px;'></div>";

        $comments .= "<div class='container'>
                            <button type='button' class='btn btn-info' data-toggle='collapse' data-target='#demo".$i."'>Comment</button>
                            <div id='demo".$i."' class='collapse out''>
                            <form class='commentForm".$i."'>
                                <input type='hidden' name='action' value='insert_item_grade'>
                                <input type='hidden' name='itemGrade_parent' value='".$basecomment->itemGrade_id."'>
                                <input type='hidden' name='item_id' value=".$_POST['item_id'].">
                                <input type='hidden' name='itemGrade_nr' value='0' />
                                <textarea name='itemGrade_comment' style='width:100%; height:40px;'></textarea>
                                <button type='button' onclick='addComment(\"commentForm".$i."\",".$_POST['item_id'].")'>Submit
                            </form>
                            </div>
                            </div>";
        $i+=1;
    }

    echo $comments;
}


function buildCommentTree($grade){
    global $sub_comment;
    global $base_comments;
    global $comments;
    global $i;

    if(isset($sub_comment[(int)$grade->itemGrade_id])){
        $sub_comment_children = $sub_comment[(int)$grade->itemGrade_id];
        foreach ($sub_comment_children as $comment_children) {

            $comments .= "<hr style='margin-top:3px; margin-bottom:3px;'><strong>" . $comment_children->user_firstName ;
            $comments .= " Says: <br><p>". $comment_children->itemGrade_comment."</p> <div style='margin-left:25px; padding-left:5px; border-left:1px gray solid;'>";

            buildCommentTree($comment_children);

            $comments .= "<hr style='margin-top:3px; margin-bottom:3px;'></div>";

            $comments .= "
                            <div class='container'>
                            <button type='button' class='btn btn-info' data-toggle='collapse' data-target='#demo".$i."'>Comment</button>
                            <div id='demo".$i."' class='collapse out''>
                            <form class='commentForm".$i."'>
                                <input type='hidden' name='action' value='insert_item_grade'>
                                <input type='hidden' name='itemGrade_parent' value='".$comment_children->itemGrade_id."'>
                                <input type='hidden' name='item_id' value=".$_POST['item_id'].">
                                <input type='hidden' name='itemGrade_nr' value='0' />
                                <textarea name='itemGrade_comment' style='width:100%; height:40px;'></textarea>
                                <button type='button' onclick='addComment(\"commentForm".$i."\",".$_POST['item_id'].")'>Submit
                            </form>
                            </div>
                            </div>";
            $i+=1;
        }
    }


}
