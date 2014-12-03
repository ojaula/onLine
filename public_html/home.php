<?php
//Start session
session_start();
 
//Check whether the session variable SESS_MEMBER_ID is present or not
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
    header("location: index.php");
    exit();
    
    /*
Destroy  sess_user_id
    unset($_SESSION['sess_user_id']);

or destroy all sessions:
    session_destroy();
*/
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home Page</title>
</head>
 
<body>
<h1>Welcome, <?php echo $_SESSION["sess_username"] ?></h1>
<?php
$MySQL_hostname = "boff.se.mysql";
$MySQL_username = "boff_se";
$MySQL_password = "wyAS5tt4";
$MySQL_databaseName = "boff_se";
$mysqli= new mysqli($MySQL_hostname, $MySQL_username, $MySQL_password, $MySQL_databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$query = ("SELECT
userItems.useritemID,
userItems.Users_UserID,
userItems.items_ItemID,
items.ItemID,
items.itemName,
items.itemPrice,
items.itemWeight,
items.itemDescShort,
items.itemDescLong,
items.itemImage,
items.itemCategory,
items.itemUpdate,
items.itemStock,
items.itemRank,
itemCategories.CategoryID,
itemCategories.CategoryName,
itemCategories.CategoryImage

 FROM  userItems
 INNER JOIN items ON ( userItems.items_ItemID = items.ItemID)
 INNER JOIN itemCategories on (items.itemCategory = itemCategories.CategoryID)
 LIMIT 0 , 30");

$myOldWayOfDoingThis = "select * from table1, table2 where table1.foriegnKeyid == table2.id"; // bad

if ($stmt = $mysqli->prepare($query)) {

    $stmt->execute();

    $stmt->bind_result(
        $useritemID,
        $Users_UserID,
        $items_ItemID,
        $ItemID,
        $itemName,
        $itemPrice,
        $itemWeight,
        $itemDescShort,
        $itemDescLong,
        $itemImage,
        $itemCategory,
        $itemUpdate,
        $itemStock,
        $itemRank,
        $CategoryID,
        $CategoryName,
        $CategoryImage
    );
    echo "Results are as following";
    echo "<table>\n";
    echo "\t<tr>\n";
    echo "\t\t<td>useritemID</td>\n";
    echo "\t\t<td>Users_UserID</td>\n";
    echo "\t\t<td>items_ItemID</td>\n";
    echo "\t\t<td><ItemID/td>\n";
    echo "\t\t<td>itemName</td>\n";
    echo "\t\t<td>itemPrice</td>\n";
    echo "\t\t<td>itemWeight</td>\n";
    echo "\t\t<td>itemDescShort</td>\n";
    echo "\t\t<td>itemDescLong</td>\n";
    echo "\t\t<td>itemImage</td>\n";
    echo "\t\t<td>itemCategory</td>\n";
    echo "\t\t<td>itemUpdate</td>\n";
    echo "\t\t<td>itemStock</td>\n";
    echo "\t\t<td>itemRank</td>\n";
    echo "\t\t<td>CategoryID</td>\n";
    echo "\t\t<td>CategoryName</td>\n";
    echo "\t\t<td>CategoryImage</td>\n";


    while ($stmt->fetch()) {


        printf("<tr>
        <td>[%d]</td>
         <td>D[%d]</td>
         <td>[%d]</td>
         <td>[%d]</td>
         <td>[%s]</td>
         <td>[%d]</td>
         <td>[%d]</td>
         <td>[%s]</td>
         <td>[%s]</td>
         <td>[%s]</td>
         <td>[%d]</td>
         <td>[%s]</td>
         <td>[%d]</td>
         <td>[%d]</td>
         <td>[%d]</td>
         <td>[%s]</td>
         <td>[%s]</td>
         </tr>

        ",
            $useritemID,
            $Users_UserID,
            $items_ItemID,
            $ItemID,
            $itemName,
            $itemPrice,
            $itemWeight,
            $itemDescShort,
            $itemDescLong,
            $itemImage,
            $itemCategory,
            $itemUpdate,
            $itemStock,
            $itemRank,
            $CategoryID,
            $CategoryName,
            $CategoryImage
        );
        //echo $stmt;
    }
    echo "</table>";
}
else
{
    echo ("there are no records avaialable");
}

/*
 *

 useritemID[%d] <br>
         Users_UserID[%d]<br>
         items_ItemID[%d]<br>
         ItemID[%d]<br>
         itemName[%s]<br>
         itemPrice[%d]<br>
         itemWeight[%d]<br>
         itemDescShort[%s]<br>
         itemDescLong[%s]<br>
         itemImage[%s]<br>
         itemCategory[%d]<br>
         itemUpdate[%s]<br>
         itemStock[%d]<br>
         itemRank[%d]<br>
         CategoryID[%d]<br>
         CategoryName[%s]<br>
         CategoryImage[%s]
         </tr>


[Users]
UserID
UserFirstName
UserLastName
UserPassword
UserEmail
UserPhone
UserAddress
UserZip
UserCity
UserVerificationCode
UserCountry
UserRegDate
UserEmailVerified
UserTools


 [userItems]
useritemID
Users_UserID
items_ItemID
$

[items]
ItemID
itemName
itemPrice
itemWeight
itemDescShort
itemDescLong
itemImage
itemCategory
itemUpdate
itemStock
itemRank

[itemCategories]
CategoryID
CategoryName
CategoryImage
 */
?>


<a href="../resources/logout.php"> Logout Destroy Session</a>
<?php

?>

</body>
</html>