<?php
require "function.php";

if(!isset($_SESSION['login'])){

}else{
    header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-dark">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create User</h3></div>
                                    <div class="card-body">

                            
                                    
                                        <form method="post">
                                        <div class="small mb-3 text-muted">Enter your New Username and New Password to Create Username for the login.</div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputuser" name="newusername" type="text" placeholder="Username" required />
                                                <label for="inputuser"> New Username</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputPassword" name="newpassword" type="password" placeholder="Password" required />
                                                <label for="inputPassword">New Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-2">
                                                <button type="submit" name="create" class="btn btn-primary">Create</a></button>
                                                <a href="login.php" class="btn btn-primary">Back</a>
                                            </div>
                                        </form>



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
