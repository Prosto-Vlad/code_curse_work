<?php
$assetManager = $this->getAssetManager();
$assetManager->bundles['yii\web\JqueryAsset'] = [
    'sourcePath' => null,
    'js' => [],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body class="d-flex align-items-center min-vh-100" style="background-color: #ddf3e5;">
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" href="<?=\yii\helpers\Url::to(['admin/worker']);?>" style="text-decoration: underline;"><img src="/img/left.png" alt="Back" width="40" height="40"></a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 7%;">
        <div class="container mt-5">
            <div class="col-md-8">
                <div class="mb-3">
                    <div class="input-group">
                        <input type="text" aria-label="Last name" id="last_name_add" class="form-control" placeholder="Прізвище">
                        <input type="text" aria-label="First name" id="first_name_add" class="form-control" placeholder="Ім'я">
                        <input type="text" aria-label="Middle name" id="middle_name_add" class="form-control" placeholder="Патронім">
                    </div>
                    
                    <div class="mb-3">
                        <label for="number" class="form-label">Номер телефону</label>
                        <input type="number" class="form-control" id="number">
                    </div>
                        
                    <div class="mb-3">
                        <label for="date" class="form-label">Дата народження</label>
                        <input type="date" class="form-control" id="date">
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Роль</label>
                        <select class="form-control" id="role">
                            <option value="">Виберіть роль</option>
                            <option value="2">Адміністратор</option>
                            <option value="1">Бібліотекарь</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Логін</label>
                        <input type="text" class="form-control" id="login_modal">
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Пароль</label>
                        <input type="text" class="form-control" id="pass_modal">               
                    </div>
                </div>
                <div class="row mt-5">
                    <button id="upd_b" type="submit" class="btn btn-primary mt-2" style="background-color: #008c6c; border-color:#008c6c;">Зберегти</button>
                </div>
            </div>
            
        </div>
    </div>

    
</body>
</html>
<?php

use yii\web\View;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

$this->registerJs("
    $(document).ready(function() {
        $('#last_name_add').val('" . $worker->second_name . "');
        $('#first_name_add').val('" . $worker->first_name . "');
        $('#middle_name_add').val('" . $worker->middle_name . "');
        $('#number').val('" . $worker->phone_number . "');
        $('#date').val('" . $worker->birthd_date . "');
        $('#role').val('" . $worker->role_id . "');
        $('#login_modal').val('" . $worker->login . "');
    });
", View::POS_READY);

$this->registerJs("
    $('#upd_b').click(function(e){
        e.preventDefault();
        var last_name = $('#last_name_add').val();
        var first_name = $('#first_name_add').val();
        var middle_name = $('#middle_name_add').val();
        var number = $('#number').val();
        var date = $('#date').val();
        var role = $('#role').val();
        var login = $('#login_modal').val();
        var pass = $('#pass_modal').val();

        
        $.ajax({
            url: '" . \yii\helpers\Url::to(['admin/worker-edit', 'id' => $worker->id]) . "',
            type: 'post',
            dataType: 'json',
            data: {
                second_name: last_name,
                first_name: first_name,
                middle_name: middle_name,
                phone_number: number,
                birthday: date,
                role_id: role,
                login: login,
                password: pass
            },
            success: function(response) {
                if(response.status === 'success') {
                    window.location.href = '" . \yii\helpers\Url::to(['admin/worker']) . "';
                }
            }
        });
    });
", View::POS_READY);
