<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center min-vh-100" style="background-color: #ddf3e5;">
    <div class="site-index">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                    <label for="login" class="form-label">Логін</label>
                                    <input type="text" id="name-input" name="login" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Пароль</label>
                                    <input type="password" id="pass-input" name="password" class="form-control" required>
                                </div>

                                <button type="submit-btn" id="submit-btn" class="btn btn-lg btn-block" style="background-color: #f48412; color: white">Увійти</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php

use yii\web\View;

$this->registerJs("
    $('#submit-btn').click(function(e){
        e.preventDefault();
        var name = $('#name-input').val();
        var pass = $('#pass-input').val();
        $.ajax({
            url: '". \yii\helpers\Url::to(['login/auth']) ."',
            type: 'post',
            dataType: 'json',
            data: {name: name, pass: pass},
            success: function(response) {
            }
        });
    });
", View::POS_READY);
?>
</body>

</html>

