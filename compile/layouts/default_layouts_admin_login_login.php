<html>
<head>
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet" href="/3rdparty/bootstrap3/css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="/3rdparty/bootstrap3/css/bootstrap-theme.min.css" />
    <script type="text/javascript" src="/3rdparty/bootstrap3/js/bootstrap.min.js"></script>

</head>

<body>
<div style="margin-top: 100px;" class="container">

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Đăng nhập</h3>
                </div>
                <div class="panel-body">
                    <form accept-charset="UTF-8" action="/admin_login" method="post" role="form">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Username" name="username" type="text" />
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="" />
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me" /> Remember Me
                                </label>
                            </div>
                            <input class="btn btn-lg btn-success btn-block" type="submit" value="Login" />
                        </fieldset>
                        <?php
                        $messages = pzk_notifier_messages();
                        if($messages) {
                            ?>
                            <?php foreach ( $messages as $item ) : ?>
                            <h4 style="color: red;"><?php echo isset($item['message'])?$item['message']: '';?></h4>
                            <?php endforeach; ?>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>