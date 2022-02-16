<?php include("header.php"); ?>
<div class="container-fluid">
    <div class="row">
        <div class="span2">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li><a href="/">Home</a></li>
                    <li><a href="/?step=1">HTTP Methods</a></li>
                    <li><a href="/?step=2">HTTP Headers</a></li>
                    <li><a href="/?step=3">HTTP Redirection</a></li>
                    <li><a href="/?step=4">HTTP Cookies</a></li>
                </ul>
                <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
            </div>
        </div>
        <div class="content">
            <h1>HTTP Methods</h1>
                <p>
                    HTTP offers multiple methods (with some extensions, like WebDAV, but you won't see them much).
                    The five most used are:
                    <ul>
                        <li>GET: Get a resource specified by the request URI. Parameters can be passed in the query string (/foo.php<b>?a=1&b=2</b>).</li>
                        <li>POST: Send data to a server (for example, the content of a form). Parameters are passed in the body of the requests.</li>
                        <li>PUT: Used to create a resource at the requested URI. Data is passed inside the body of the request. </li>
                        <li>DELETE: The opposite of PUT. Used to delete the resource at the request URI.</li>
                        <li>HEAD: Retrieve only the response headers, without the body.</li>
                    </ul>
                </p>
                <?php
                if (isset($_POST['login']) && isset($_POST['password'])) {
                    echo 'Well done!';
                }
                else {
                       ?>
                <p><a href='/post.php'>This page</a> expects a POST request with two parameters, login and password, but you won't find anywhere on the page to input these parameters.<br />
                    Instead, you'll have to complete this request manually with curl (look at the -d option).</p>
                <?php
                }
                ?>
        </div>
    </div>
</div>
</html>
