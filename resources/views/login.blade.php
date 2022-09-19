<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous" />
    <!-- Custom fonts for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <title>Login</title>
  </head>
  <body class="d-flex bg-login-image">
    <div class="container-fluid m-auto">
      <!-- Outer Row -->
      <div class="row justify-content-center m-0 p-0">
        <div class="col-xl-4 col-lg-10 col-md-12">
          <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
              <!-- Nested Row within Card Body -->
              <div class="row">
                <!-- <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> -->
                <div class="col-12">
                  <div class="p-5">
                    <div class="text-center">
                      <h4 class="h4 font-weight-bold text-gray-900 mb-4">Login</h4>
                    </div>
                    <form class="user" method="POST" action="/login">
                      @csrf
                      <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" />
                      </div>
                      <div class="form-group">
                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password" />
                      </div>
                      <div class="form-group d-flex">
                        <button type="submit" class="btn btn-primary btn-user btn-block m-auto w-auto">Masuk</button>
                      </div>
                      <hr />
                    </form>
                    <hr />
                    <div class="text-center">
                      <a class="h3 text-gray-900" href="register.html">Aplikasi Monitoring SI</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
  </body>
</html>
