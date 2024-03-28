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
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" href="<?=\yii\helpers\Url::to(['admin/catalog']);?>" >Назад</a>
                </div>
            </div>
    </nav>
    <div class="container mt-5">
        <div class="container mt-5">
        <div class="container-fluid">
            <label for="bookName" class="form-label">Назва книги</label>
            <input type="text" class="form-control" id="bookName">

            <label for="publisher" class="form-label">Видавець</label>
            <select class="form-select" id="publisher">
                <option value="0"></option>
                <?php foreach ($publishers as $publisher): ?>
                    <option value="<?= $publisher->id ?>"><?= $publisher->name ?></option>
            <?php endforeach; ?>
            </select>

            <label for="author" class="form-label">Автор</label>
            <select class="form-select" id="author">
                <option value="0"></option>
                <?php foreach ($authors as $author): ?>
                    <option value="<?= $author->id ?>"><?= $author->second_name . ' ' . $author->first_name ?></option>
                <?php endforeach; ?>
            </select>

            <label for="publishYear" class="form-label">Рік випуску</label>
            <input type="date" class="form-control" id="publishYear">

            <label for="tags" class="form-label">Теги</label>
            <select class="js-example-basic-multiple form-control" id="select-main" name="states[]" multiple="multiple">
                <?php foreach ($tags as $tag): ?>
                    <option value="<?= $tag->id ?>"><?= $tag->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>
<div class="d-flex justify-content-end">
    <button id="add_b" type="submit" class="btn btn-primary mt-2" style="background-color: #008c6c; border-color:#008c6c;">Додати</button>
</div>

<?php

use yii\web\View;

$this->registerJs("
    $(document).ready(function() {
        $('#select-main').select2();
    });

    $('#add_b').click(function(e){
        e.preventDefault();
        var name = $('#bookName').val();
        var publisher = $('#publisher').val();
        var author = $('#author').val();
        var publishYear = $('#publishYear').val();
        var tags = $('#select-main').val();

        var inputDateObj = new Date(publishYear);
        var currentDate = new Date();

        if (inputDateObj > currentDate) {
            alert('Дата публікації не може бути пізнішою за сьогоднішню.');
            return;
        }

        $.ajax({
            url: '". \yii\helpers\Url::to(['admin/catalog-add']) ."',
            type: 'post',
            dataType: 'json',
            data: {name: name, publisher: publisher, author: author, publishYear: publishYear, tags: tags},
            success: function(response) {
                location.reload();
            }
        });
    
    });
", View::POS_READY);
?>
</body>
