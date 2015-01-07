<form data-callback="ajaxCallback_loginEvent" id="form_Login"  name="form_Login" class="nav navbar-nav navbar-form navbar-right" role="login" method="post" action="login.php">
    <div class="form-group">

        <input type="hidden" name="action" value="get_login">
        <input class="form-control" type="text" name="username" id="username" placeholder="User name [foo]" alt="User name"/>
        <input class="form-control" type="password" name="password" id="password" placeholder="password [bar]"
               alt="password"/>
        <button type="submit" class="btn btn-default"> Login</button>
    </div>
</form>
<ul class="nav navbar-nav navbar-right">

    <li><a href="#section_shop"   ><span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart</a></li>

    <li><a href="#section_user_details">Create Account</a></li>
<script>
    if (globalAjaxInit == true)
    {



            // force the nav_link scan again, it's broken on dynamic load in.
        $("#navLinks a").click(function(e){
            e.preventDefault();
            $(this).tab('show');
        });

        formSubmitEvent_bindAll();

    } </script>
</ul>
