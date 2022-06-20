<!DOCTYPE html>
<html lang="en" dir="ltr">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title>WIS :: Login</title>
        <style>
            .error{
                color: red;
            }
        </style>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">WIS Admin</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 pt-3 pb-3 bg-white from-wrapper">
                    <div class="container">
                        <?php if (session('errmsg')) : ?>
                            <div class="alert alert-danger alert-dismissible">
                                <?= session('errmsg') ?>
                                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                            </div>
                        <?php endif ?>
                        <h3>Login</h3>
                        <hr>
                        <form action="" method="post" id="Form">
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" name="Email" id="Email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="Password" id="Password" value="">
                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-4 ">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="<?= base_url() ?>/public/admin_assets/plugins/jquery/jquery.min.js"></script>
        <!-- Validation -->
        <script src="<?= base_url() ?>/public/admin_assets/plugins/jquery-validation/jquery.validate.min.js"></script>
        <script>
            $(function() {
                $("form[id='Form']").validate({
                    rules: {
                        Email: {
                            required: true,
                            normalizer: function(value) {
                                return $.trim(value);
                            },
                            email: true
                        },
                        Password: {
                            required: true
                        }
                    },
                    messages: {
                        Email: {
                            required: "Please enter a email",
                            email: "Please enter a valid email address"
                        },
                        Password: {
                            required: "Please enter a password"
                        },
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
            });
        </script>

    </body>
    
</html>
