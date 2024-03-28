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
                        <a class="nav-link" href="<?=\yii\helpers\Url::to(['admin/writeoff']);?>" style="text-decoration: underline;">Списання</a>
                        <a class="nav-link" href="<?=\yii\helpers\Url::to(['admin/worker']);?>">Робітники</a>
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
            <div class="row mt-2">
                    <div class="col-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Номер</th>
                                    <th scope="col">Назва</th>
                                    <th scope="col">Автор</th>
                                    <th scope="col">Видавництво</th>
                                    <th scope="col">Рік випуску</th>
                                    <th scope="col">Коментар</th>
                                    <th scope="col"></th>
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
    </div>
</body>

</html>
<?php

use yii\web\View;
$this->registerJs("
    $(document).ready(function() {

        $.ajax({
            url: '". \yii\helpers\Url::to(['admin/outoff']) ."',
            type: 'post',
            dataType: 'json',
            data: {
            },
            success: function(response) {
                $('#t_body').empty(); 

                // Loop through the books in the response
                $.each(response.write, function(index, off) {
                    $('#t_body').append(
                        '<tr>' +
                            '<td>' + off.wid + '</td>' +
                            '<td>' + off.book_name + '</td>' +
                            '<td>' + off.second_name + ' ' + off.first_name + '</td>' +
                            '<td>' + off.name + '</td>' +
                            '<td>' + off.year_of_publication + '</td>' +
                            '<td>' + off.comment + '</td>' +
                            '<td>' + 
                                '<a href=\"' + '". \yii\helpers\Url::to(['admin/agree', 'id' => '']) ."' + off.wid +  '\">' +
                                    'Так' +
                                '</a>' +
                            '</td>' +
                            '<td>' + 
                                '<a href=\"' + '". \yii\helpers\Url::to(['admin/disagree', 'id' => '']) ."' + off.wid +  '\">' +
                                    'Ні' +
                                '</a>' +
                            '</td>' +
                        '</tr>'
                    );
                });
            }
        });

    });
", View::POS_READY);