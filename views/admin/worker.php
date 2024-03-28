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
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top ">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="navbar-brand"><?=Yii::$app->session->get('user')['second_name'] . '' . Yii::$app->session->get('user')['first_name'];?></a>
                        <a class="nav-link" href="<?=\yii\helpers\Url::to(['admin/writeoff']);?>">Списання</a>
                        <a class="nav-link" href="<?=\yii\helpers\Url::to(['admin/worker']);?>" style="text-decoration: underline;">Робітники</a>
                        <a class="nav-link" href="<?=\yii\helpers\Url::to(['admin/catalog']);?>">Каталог</a>
                        <a class="nav-link" href="<?=\yii\helpers\Url::to(['admin/tag']);?>">Теги</a>
                        <a class="nav-link" href="<?=\yii\helpers\Url::to(['admin/author']);?>">Автори</a>
                        <a class="nav-link" href="<?=\yii\helpers\Url::to(['admin/publisher']);?>">Видавництва</a>
                    </div>
                </div>


                <div class="navbar-nav d-flex align-items-center">
                    <a class="nav-link" href="<?=\yii\helpers\Url::to(['login/logout']);?>">Вихід</a>
                </div>
            </div>
    </nav>

    <div class="container" style="margin-top: 7%;">
        <div class="container mt-5">
            <div class="row mt-5">
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

                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="d-flex justify-content-between">
                    <button id="search" type="submit" class="btn btn-primary mt-2" style="background-color: #008c6c; border-color:#008c6c;">Пошук</button> 
                    <button id="add_modal_b" type="submit" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#add_modal" style="background-color: #008c6c; border-color:#008c6c;">Додати</button>
                    <div class="modal fade" id="add_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Додати автора</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="input-group">
                                        <input type="text" aria-label="Last name" id="last_name_modal" class="form-control" placeholder="Прізвище">
                                        <input type="text" aria-label="First name" id="first_name_modal" class="form-control" placeholder="Ім'я">
                                        <input type="text" aria-label="Middle name" id="middle_name_modal" class="form-control" placeholder="Патронім">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="number" class="form-label">Номер телефону</label>
                                        <input type="number" class="form-control" id="number_modal">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Дата народження</label>
                                        <input type="date" class="form-control" id="date_modal">
                                    </div>

                                    <div class="mb-3">
                                        <label for="role" class="form-label">Роль</label>
                                        <select class="form-control" id="role_modal">
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
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                                    <button id="add_b" type="button" class="btn btn-primary" style="background-color: #008c6c; border-color:#008c6c;">Додати</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Номер</th>
                                <th scope="col">ПІБ</th>
                                <th scope="col">Номер телефону</th>
                                <th scope="col">Дата народження</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="t_body">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php

    use yii\web\View;
    $this->registerJs("
        $(document).ready(function() {
            let role = document.getElementById('role');
            $.ajax({
                url: '". \yii\helpers\Url::to(['admin/workerout']) ."',
                type: 'post',
                dataType: 'json',
                data: {
                    first_name: $('#first_name_add').val(),
                    second_name: $('#last_name_add').val(),
                    middle_name: $('#middle_name_add').val(),
                    phone: $('#number').val(),
                    date: $('#date').val(),
                    role_id: role.options[role.selectedIndex].value
                },
                success: function(response) {
                    $('#t_body').empty(); 

                    $.each(response.workers, function(index, worker) {
                        $('#t_body').append(
                            '<tr>' +
                                '<td>' + worker.id + '</td>' +
                                '<td>' + worker.second_name + ' ' + worker.first_name + ' ' + worker.middle_name + '</td>' +
                                '<td>' + worker.phone_number + '</td>' +
                                '<td>' + worker.birthd_date + '</td>' +
                                '<td><a href=\"' + '". \yii\helpers\Url::to(['admin/worker-info', 'id' => '']) ."' + worker.id +  '\"><img src=\"/img/info.png\" alt=\"View Details\" style=\"width:40px;height:40px;\" /></a></td>' +
                            '</tr>'
                        );
                    });
                }
            });

        });
    ", View::POS_END);

    $this->registerJs("
        $('#search').click(function(e){
            $.ajax({
                url: '". \yii\helpers\Url::to(['admin/workerout']) ."',
                type: 'post',
                dataType: 'json',
                data: {
                    first_name: $('#first_name_add').val(),
                    second_name: $('#last_name_add').val(),
                    middle_name: $('#middle_name_add').val(),
                    phone: $('#number').val(),
                    date: $('#date').val(),
                    role_id: $('#role').val()
                },
                success: function(response) {
                    $('#t_body').empty(); 

                    $.each(response.workers, function(index, worker) {
                        $('#t_body').append(
                            '<tr>' +
                                '<td>' + worker.id + '</td>' +
                                '<td>' + worker.second_name + ' ' + worker.first_name + ' ' + worker.middle_name + '</td>' +
                                '<td>' + worker.phone_number + '</td>' +
                                '<td>' + worker.birthd_date + '</td>' +
                                '<td><a href=\"' + '". \yii\helpers\Url::to(['admin/worker-info', 'id' => '']) ."' + worker.id +  '\"><img src=\"/img/info.png\" alt=\"View Details\" style=\"width:40px;height:40px;\" /></a></td>' +
                            '</tr>'
                        );
                    });
                }
            });
        });
    ", View::POS_END);

    $this->registerJs("
    $('#add_b').click(function(e){
        e.preventDefault();
        let second_name = $('#last_name_modal').val();
        let first_name = $('#first_name_modal').val();
        let middle_name = $('#middle_name_modal').val();
        let phone = $('#number_modal').val();
        let date = $('#date_modal').val();
        let role_id = $('#role_modal').val();
        let login = $('#login_modal').val();
        let pass = $('#pass_modal').val();

        $.ajax({
            url: '". \yii\helpers\Url::to(['admin/worker-add']) ."',
            type: 'post',
            dataType: 'json',
            data: {
                second_name: second_name,
                first_name: first_name,
                middle_name: middle_name,
                phone_number: phone,
                birthday: date,
                role_id: role_id,
                login: login,
                password: pass
            },
            success: function(response) {
                location.reload();
            }
        });
    
    });
    ", View::POS_END);
    ?>
</body>
</html>