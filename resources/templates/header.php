<section style="margin:0px; padding:0px;" class="header">
    <nav class="navbar navbar-inverse navbar-static-top " role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header ">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Brand</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling ,  used from http://getbootstrap.com/components/#navbar-->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">


                <div id="user_section">
                <?php
                if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == ''))
                {
                    //header("location: login.html");
                    require_once(TEMPLATES_PATH . "/header_unregistered.php");

                }
                else
                {
                    require_once(TEMPLATES_PATH . "/header_hasLoggedin.php");
                }
                ?>
                </div>


            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <div id="responseArea" style="color:floralwhite"></div>
    <!--Site LOGO  -->
    <div class="row">
        <div class="col-xs-1 col-md-1"></div>
        <div class="col-xs-2 col-xs-offset-1 col-md-2 col-md-offset-3"><img src=images/siteLogo.png></div>
        <div class="col-xs-0 col-md-5"><div class="clearfix hidden-xs"><img src="images/siteLogoText.png"></div></div>
    </div>


</section>

<?php

?>