<?php
$assetManager = $this->getAssetManager();
$assetManager->bundles['yii\web\JqueryAsset'] = [
    'sourcePath' => null,
    'js' => [],
];
?>

<?php
$authors = \app\models\Author::find()->all();
$publishers = \app\models\Publisher::find()->all();
$tags = \app\models\Tag_t::find()->where(['enabled' => true])->all();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>

<body style="background-color: #ddf3e5;">
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top ">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="navbar-brand"><?=Yii::$app->session->get('user')['second_name'] . '' . Yii::$app->session->get('user')['first_name'];?></a>
                    <a class="nav-link" href="<?=\yii\helpers\Url::to(['librarian/catalog']);?>" style="text-decoration: underline;">Каталог</a>
                    <a class="nav-link" href="<?=\yii\helpers\Url::to(['librarian/takeof']);?>">Видача</a>
                </div>
            </div>


            <div class="navbar-nav d-flex align-items-center">
                <a class="nav-link" href="<?=\yii\helpers\Url::to(['login/logout']);?>">Вихід</a>
            </div>
        </div>
    </nav>

    <div class="container " style="margin-top: 7%;">
        <div class="container mt-5">
            <div class="row mt-5">
                <div class="col">
                    <div class="mb-3">
                        <label for="bookName" class="form-label">Назва книги</label>
                        <input type="text" class="form-control" id="bookName">
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="publisher" class="form-label">Видавець</label>
                        <select class="form-select" id="publisher">
                            <option value="0"></option>
                            <?php foreach ($publishers as $publisher): ?>
                                <option value="<?= $publisher->id ?>"><?= $publisher->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="author" class="form-label">Автор</label>
                        <select class="form-select" id="author">
                            <option value="0"></option>
                            <?php foreach ($authors as $author): ?>
                                <option value="<?= $author->id ?>"><?= $author->second_name . ' ' . $author->first_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="publishYear" class="form-label">Рік випуску</label>
                        <input type="date" class="form-control" id="publishYear">
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="mb-3">
                    <label for="tags" class="form-label">Теги</label>
                    <select class="js-example-basic-multiple form-control" id="select-main" name="states[]" multiple="multiple">
                        <?php foreach ($tags as $tag): ?>
                                <option value="<?= $tag->id ?>"><?= $tag->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="col">
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="filter" value="free" id="free">
                        <label class="form-check-label" for="free">
                            Вільні
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="filter" value="archived" id="archived">
                        <label class="form-check-label" for="archived">
                            Архівовані
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="filter" value="notAvailable" id="notAvailable">
                        <label class="form-check-label" for="notAvailable">
                            Не доступні
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="filter" value="onHand" id="onHand">
                        <label class="form-check-label" for="onHand">
                            На руках
                        </label>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <button id="found_b" type="submit" class="btn btn-primary mt-2" style="background-color: #008c6c; border-color:#008c6c;">Пошук</button> 
                <button id="add_b" type="submit" class="btn btn-primary mt-2" style="background-color: #008c6c; border-color:#008c6c;">Додати</button>
            </div>
        </div>

        


        <div class="row mt-">
            <div class="col-12">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Номер</th>
                            <th scope="col">Назва</th>
                            <th scope="col">Автор</th>
                            <th scope="col">Видавництво</th>
                            <th scope="col">Рік випуску</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody id="t_body">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

<script>

</script>

<?php

use yii\web\View;

$this->registerJs("
    $(document).ready(function() {
        $('#select-main').select2();

    });

    $('#add_b').click(function(e){
        window.location.href = '". \yii\helpers\Url::to(['librarian/add']) ."';
    });

    $('#found_b').click(function(e){
        e.preventDefault();

        var bookName = $('#bookName').val();
        var author = $('#author').val();
        var publisher = $('#publisher').val();
        var publishYear = $('#publishYear').val();
        var selectedTags = $('#select-main').val();

        var archived = $('#archived').prop('checked');
        var notAvailable = $('#notAvailable').prop('checked');
        var onHand = $('#onHand').prop('checked');

        $.ajax({
            url: '". \yii\helpers\Url::to(['librarian/found']) ."',
            type: 'post',
            dataType: 'json',
            data: {
                bookName: bookName,
                author: author,
                publisher: publisher,
                publishYear: publishYear,
                tags: selectedTags,

                archived: archived,  
                notAvailable: notAvailable,
                onHand: onHand
            },
            success: function(response) {
                $('#t_body').empty(); 

                // Loop through the books in the response
                $.each(response.books, function(index, book) {
   
                    $('#t_body').append(
                        '<tr>' +
                            '<td>' + book.id + '</td>' +
                            '<td>' + book.name + '</td>' +
                            '<td>' + book.second_name + ' ' + book.first_name + '</td>' +
                            '<td>' + book.publisher_name + '</td>' +
                            '<td>' + book.year_of_publication + '</td>' +
                            '<td>' + 
                                '<a href=\"' + '". \yii\helpers\Url::to(['librarian/info', 'id' => '']) ."' + book.id +  '\">' +
                                    '<img src=\"/img/info.png\" alt=\"View Details\" style=\"width:40px;height:40px;\" />' +
                                '</a>' +
                            '</td>' +
                        '</tr>'
                    );
                });
            }
        });
    });
", View::POS_READY);
?>


</html>