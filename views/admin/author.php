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
                        <a class="nav-link" href="<?=\yii\helpers\Url::to(['admin/worker']);?>">Робітники</a>
                        <a class="nav-link" href="<?=\yii\helpers\Url::to(['admin/catalog']);?>">Каталог</a>
                        <a class="nav-link" href="<?=\yii\helpers\Url::to(['admin/tag']);?>">Теги</a>
                        <a class="nav-link" href="<?=\yii\helpers\Url::to(['admin/author']);?>" style="text-decoration: underline;">Автори</a>
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

                        <div class="input-group mt-2">
                            <input type="text" aria-label="Pseudonym" id="pseudonym_add" class="form-control" placeholder="Псеудонім">
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

                                    <div class="input-group mt-2">
                                        <input type="text" aria-label="Pseudonym" id="pseudonym_modal" class="form-control" placeholder="Псеудонім">
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
                                <th scope="col">Прізвище</th>
                                <th scope="col">Ім'я</th>
                                <th scope="col">По-батькові</th>
                                <th scope="col">Псеудонім</th>
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
            
            $.ajax({
                url: '". \yii\helpers\Url::to(['admin/authorout']) ."',
                type: 'post',
                dataType: 'json',
                data: {
                    first_name: $('#first_name_add').val(),
                    second_name: $('#last_name_add').val(),
                    middle_name: $('#middle_name_add').val(),
                    pseudonym: $('#pseudonym_add').val()
                },
                success: function(response) {
                    $('#t_body').empty(); 

                    $.each(response.authors, function(index, author) {
                        $('#t_body').append(
                            '<tr>' +
                                '<td>' + author.id + '</td>' +
                                '<td>' + author.second_name + '</td>' +
                                '<td>' + author.first_name + '</td>' +
                                '<td>' + author.middle_name + '</td>' +
                                '<td>' + author.pseudonym + '</td>' +
                                '<td><a href=\"' + '". \yii\helpers\Url::to(['admin/author-info', 'id' => '']) ."' + author.id +  '\"><img src=\"/img/info.png\" alt=\"View Details\" style=\"width:40px;height:40px;\" /></a></td>' +
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
                url: '". \yii\helpers\Url::to(['admin/authorout']) ."',
                type: 'post',
                dataType: 'json',
                data: {
                    first_name: $('#first_name_add').val(),
                    second_name: $('#last_name_add').val(),
                    middle_name: $('#middle_name_add').val(),
                    pseudonym: $('#pseudonym_add').val()
                },
                success: function(response) {
                    $('#t_body').empty(); 

                    $.each(response.authors, function(index, author) {
                        $('#t_body').append(
                            '<tr>' +
                                '<td>' + author.id + '</td>' +
                                '<td>' + author.second_name + '</td>' +
                                '<td>' + author.first_name + '</td>' +
                                '<td>' + author.middle_name + '</td>' +
                                '<td>' + author.pseudonym + '</td>' +
                                '<td><a href=\"' + '". \yii\helpers\Url::to(['admin/author-info', 'id' => '']) ."' + author.id +  '\"><img src=\"/img/info.png\" alt=\"View Details\" style=\"width:40px;height:40px;\" /></a></td>' +
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
        var second_name = $('#last_name_modal').val();
        var first_name = $('#first_name_modal').val();
        var middle_name = $('#middle_name_modal').val();
        var pseudonym = $('#pseudonym_modal').val();
        $.ajax({
            url: '". \yii\helpers\Url::to(['admin/author-add']) ."',
            type: 'post',
            dataType: 'json',
            data: {
                second_name: second_name,
                first_name: first_name,
                middle_name: middle_name,
                pseudonym: pseudonym
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