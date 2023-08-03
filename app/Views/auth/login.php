<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?= csrf_hash() ?>" />
        <title>Coding Test</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="/css/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="/css/adminlte/adminlte.min.css">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <b>Coding Test</b>
            </div>
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    <form id="login-form" action="/auth" method="post">
                        <div class="input-group mb-3">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="/js/jquery/jquery.min.js"></script>
        <script src="/js/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/js/adminlte/adminlte.min.js"></script>
        <script src="/js/main.js"></script>
        <script>
            $(document).ready(function(){
                $("#login-form").on("submit", function(e){
                    e.preventDefault();
                    $.ajax({
                        url: $(this).attr('action'),
                        data: $(this).serialize(),
                        type: "POST",
                        dataType: 'json',
                        success: function (data) {
                            notification('success', '', '', true);
                            setTimeout(function() {
                                window.location.replace("/");
                            }, 1250);
                        },
                        error: function (err) {
                            notification('danger', '', err.responseJSON.message, true);
                        }
                    });
                });
            });
        </script>
    </body>
</html>
