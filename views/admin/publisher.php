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
                        <a class="nav-link" href="<?=\yii\helpers\Url::to(['admin/author']);?>">Автори</a>
                        <a class="nav-link" href="<?=\yii\helpers\Url::to(['admin/publisher']);?>" style="text-decoration: underline;">Видавництва</a>
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
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="name" class="form-label">Назва</label>
                        <input type="text" class="form-control" id="name">
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
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Додати видаця</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="name_modal" class="form-label">Назва</label>
                                        <input type="text" class="form-control" id="name_modal">
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
                                <th scope="col">Назва</th>
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
                url: '". \yii\helpers\Url::to(['admin/publisherout']) ."',
                type: 'post',
                dataType: 'json',
                data: {available: $('#notAvailable').is(':checked'), name: $('#name').val()
                },
                success: function(response) {
                    $('#t_body').empty(); 

                    $.each(response.publishers, function(index, publisher) {
                        $('#t_body').append(
                            '<tr>' +
                                '<td>' + publisher.id + '</td>' +
                                '<td>' + publisher.name + '</td>' +
                                '<td><a href=\"' + '". \yii\helpers\Url::to(['admin/publisher-info', 'id' => '']) ."' + publisher.id +  '\"><img src=\"/img/info.png\" alt=\"View Details\" style=\"width:40px;height:40px;\" /></a></td>' +
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
                url: '". \yii\helpers\Url::to(['admin/publisherout']) ."',
                type: 'post',
                dataType: 'json',
                data: {available: $('#notAvailable').is(':checked'), name: $('#name').val()
                },
                success: function(response) {
                    $('#t_body').empty(); // Clear the table body

                    $.each(response.publishers, function(index, publisher) {
                        $('#t_body').append(
                            '<tr>' +
                                '<td>' + publisher.id + '</td>' +
                                '<td>' + publisher.name + '</td>' +
                                '<td><a href=\"' + '". \yii\helpers\Url::to(['admin/publisher-info', 'id' => '']) ."' + publisher.id +  '\"><img src=\"/img/info.png\" alt=\"View Details\" style=\"width:40px;height:40px;\" /></a></td>' +
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
        var name = $('#name_modal').val();
        $.ajax({
            url: '". \yii\helpers\Url::to(['admin/publisher-add']) ."',
            type: 'post',
            dataType: 'json',
            data: {name: name},
            success: function(response) {
                location.reload();
            }
        });
    
    });
    ", View::POS_END);
    ?>

    
</body>




</html>