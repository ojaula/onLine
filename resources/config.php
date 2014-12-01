<?php

/*
    The important thing to realize is that the config file should be included in every
    page of your project, or at least any page you want access to these settings.
    This allows you to confidently use these settings throughout a project because
    if something changes such as your database credentials, or a path to a specific resource,
    you'll only need to update it here.
*/

$config = array(
    "db" => array(
        "onlineDB" => array(
            "dbname" => "onLine",
            "username" => "root",
            "password" => "",
            "host" => "localhost"
        )
    ),
    "urls" => array(
        "baseUrl" => "http://example.com"
    ),
    "paths" => array(
        "resources" => "/path/to/resources",
        "images" => array(
            "content" => $_SERVER["DOCUMENT_ROOT"] . "/images/content",
            "layout" => $_SERVER["DOCUMENT_ROOT"] . "/images/layout"
        )
    ),
    "available_tools" => array(
        'pencil',
        'brush'
    ),
    "available_colors" => array(
        "r" => "1",
        "g" => "1",
        "b" => "1",
        "a" => "0",
        'value_min'=>0,      //available colors
        'value_max'=>255,
        'value_stepSize'=>1
    )

);
$host_site = "http://$_SERVER[HTTP_HOST]";
//echo $host_site ;

if ($host_site == "http://boff.se") {
    //echo " WE ARE AT BOFF.SE ALtering detials";
    // executing but not having desired effect.
    $config["db"]["onlineDB"]["host"] = "boff.se.mysql";
    $config["db"]["onlineDB"]["dbname"] = "boff_se";
    $config["db"]["onlineDB"]["username"] = "boff_se";
    $config["db"]["onlineDB"]["password"] = "wyAS5tt4";
    /*echo "it changed for $actual_link";
    echo $config["db"]["onlineDB"]["dbname"];
    echo $config["db"]["onlineDB"]["username"];
    echo $config["db"]["onlineDB"]["password"];
    echo $config["db"]["onlineDB"]["host"];
    echo "test ftp commit";
    */
}


$available_colors = array(
    "r" => "1",
    "g" => "1",
    "b" => "1",
    "a" => "0",
    'value_min'=>0,      //available colors
    'value_max'=>255,
    'value_stepSize'=>1
);

/*
    I will usually place the following in a bootstrap file or some type of environment
    setup file (code that is run at the start of every page request), but they work 
    just as well in your config file if it's in php (some alternatives to php are xml or ini files).
*/

/*
    Creating constants for heavily used paths makes things a lot easier.
    ex. require_once(LIBRARY_PATH . "Paginator.php")
*/
defined("LIBRARY_PATH")
or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/library'));

defined("TEMPLATES_PATH")
or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));

/*
    Error reporting.
*/
ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRCT);

?>