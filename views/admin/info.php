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

    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" href="<?=\yii\helpers\Url::to(['admin/catalog']);?>" style="text-decoration: underline;"><img src="/img/left.png" alt="Back" width="40" height="40"></a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 7%;" >
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

            <label for="tags" class="form-label mt-2">Теги</label>
            <select class="js-example-basic-multiple form-control" id="select-main" name="states[]" multiple="multiple">
                <?php foreach ($tags as $tag): ?>
                    <?php $selected = in_array($tag->id, array_column($book->tags, 'id')) ? 'selected' : ''; ?>
                    <option value="<?= $tag->id ?>" <?= $selected ?>><?= $tag->name ?></option>
                <?php endforeach; ?>
            </select>

            <div class="col">   
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="archived">
                        <label class="form-check-label" for="archived">
                            Архівовані
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="notAvailable">
                        <label class="form-check-label" for="notAvailable">
                            Не доступні
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="d-flex justify-content-between ">
    <button id="write_off_b" type="submit" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#modal_write" style="background-color: #FF5733; border-color:#FF5733;">Списати</button>
    <button id="give_b" type="submit" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#modal_give" style="background-color: #008c6c; border-color:#008c6c;">Видати</button>
    <button id="back_b" type="submit" class="btn btn-primary mt-2" style="background-color: #008c6c; border-color:#008c6c;">Повернути</button>
    <button id="upd_b" type="submit" class="btn btn-primary mt-2" style="background-color: #008c6c; border-color:#008c6c;">Зберегти</button>
</div>

<div class="row mt-4">
        <div class="col-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Номер</th>
                        <th scope="col">Читач</th>
                        <th scope="col">Телефон</th>
                        <th scope="col">Дата отримання</th>
                        <th scope="col">Запланована дата повернення</th>
                        <th scope="col">Фактична дата повернення</th>
                        <th scope="col">Коментар</th>
                    </tr>
                </thead>
                <tbody id="t_body">

                </tbody>
            </table>
        </div>
</div>

<div class="modal fade" id="modal_give" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Видати</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <input type="text" aria-label="Last name" id="last_name_add" class="form-control" placeholder="Прізвище">
                    <input type="text" aria-label="First name" id="first_name_add" class="form-control" placeholder="Ім'я">
                    <input type="text" aria-label="Middle name" id="middle_name_add" class="form-control" placeholder="Патронім">
                </div>

                <label for="number" class="form-label">Номер телефона</label>
                <input type="number" class="form-control" id="phone_number_add" name="phone_number">   

                <label for="promised_date" class="form-label mt-2">Запланована дата повернення</label>
                <input type="date" class="form-control" id="promised_date_add" name="promised_date">

                <label for="desk" class="form-label mt-2">Коментар</label>
                <input type="text" class="form-control" id="desk_add" name="desk">
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                    <button id="give_modal" type="button" class="btn btn-primary" style="background-color: #008c6c; border-color:#008c6c;">Видати</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_write" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Списати</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="desk" class="form-label mt-2">Коментар</label>
                <input type="text" class="form-control" id="desk_write" name="desk_write">
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                    <button id="write_modal" type="button" class="btn btn-primary" style="background-color: #008c6c; border-color:#008c6c;">Списати</button>
            </div>
        </div>
    </div>
</div>
<?php

use yii\web\View;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

$this->registerJs("
    $(document).ready(function() {
        $('#select-main').select2();

        $('#bookName').val(" . Json::encode($book->name) . ");
        $('#publisher').val(" . Json::encode($book->publisher_id) . ");
        $('#author').val(" . Json::encode($book->author_id) . ");
        $('#publishYear').val(" . Json::encode($book->year_of_publication) . ");

        $('#archived').prop('checked', " . Json::encode($book->archive) . ");
        $('#notAvailable').prop('checked', " . (Json::encode(!$book->enabled)) . ");

        var historyData = ". Json::encode($history) .";

        
        $.each(historyData, function(index, entry) {
            // Додавання рядка до таблиці
            $('#t_body').append(
                '<tr>' +
                    '<td>' + entry.id + '</td>' +
                    '<td>' + entry.second_name + ' ' + entry.first_name + ' ' + entry.middle_name + '</td>' +
                    '<td>' + entry.phone_number + '</td>' +
                    '<td>' + entry.hand_date + '</td>' +
                    '<td>' + entry.promised_date + '</td>' +
                    '<td>' + (entry.real_date !== null ? entry.real_date : \"На руках\") + '</td>' +
                    '<td>' + entry.desk + '</td>' +
                '</tr>'
            );
        });

        if (historyData.length > 0 && historyData[0].real_date === null) {
            $('#give_b').hide();
            $('#back_b').show(); 
        } else {
            $('#back_b').hide(); 
            $('#give_b').show(); 
        }
    });
", View::POS_READY);

$this->registerJs("
    $('#upd_b').click(function(e){
        e.preventDefault();
        var name = $('#bookName').val();
        var publisher = $('#publisher').val();
        var author = $('#author').val();
        var publishYear = $('#publishYear').val();
        var tags = $('#select-main').val();
        
        var archived = $('#archived').prop('checked');
        var notAvailable = $('#notAvailable').prop('checked');
        var onHand = $('#onHand').prop('checked');
        
        var inputDateObj = new Date(publishYear);
        var currentDate = new Date();

        if (inputDateObj > currentDate) {
            alert('Дата публікації не може бути пізнішою за сьогоднішню.');
            return;
        }

        $.ajax({
            url: '" . \yii\helpers\Url::to(['admin/edit', 'id' => $book->id]) . "',
            type: 'post',
            dataType: 'json',
            data: {
                bookName: name,
                author: author,
                publisher: publisher,
                publishYear: publishYear,
                tags: tags,
                archived: archived,  
                notAvailable: notAvailable,
                onHand: onHand
            },
            success: function(response) {
                if(response.status === 'success') {
                    window.location.href = '" . \yii\helpers\Url::to(['admin/catalog']) . "';
                }
            }
        });
    });
", View::POS_READY);

$this->registerJs("
    $('#give_modal').click(function(e){
        e.preventDefault();
        
        var second_name = $('#last_name_add').val();
        var first_name = $('#first_name_add').val();
        var middle_name = $('#middle_name_add').val();
        var phone_number = $('#phone_number_add').val();
        var promised_date = $('#promised_date_add').val();
        var desk = $('#desk_add').val();

        
        $.ajax({
            url: '" . \yii\helpers\Url::to(['admin/give', 'id' => $book->id]) . "',
            type: 'post',
            dataType: 'json',
            data: {
                second_name: second_name,
                first_name: first_name,
                middle_name: middle_name,
                phone_number: phone_number,
                promised_date: promised_date,
                desk: desk
            },
            success: function(response) {
                location.reload();
            }
        });
    });
", View::POS_READY);

$this->registerJs("
    $('#write_modal').click(function(e){
        e.preventDefault();

        var desk = $('#desk_write').val();

        
        $.ajax({
            url: '" . \yii\helpers\Url::to(['admin/writeoff', 'id' => $book->id]) . "',
            type: 'post',
            dataType: 'json',
            data: {
                desk: desk
            },
            success: function(response) {
                location.reload();
            }
        });
    });
", View::POS_READY);

$this->registerJs("
    $('#back_b').click(function(e){
        e.preventDefault();
        
        $.ajax({
            url: '" . \yii\helpers\Url::to(['admin/back', 'id' => $book->id]) . "',
            type: 'post',
            dataType: 'json',
            data: {
                
            },
            success: function(response) {
                location.reload();
            }
        });
    });
", View::POS_READY);
?>
</body>
