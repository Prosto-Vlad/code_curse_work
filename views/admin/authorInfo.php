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
                    <a class="nav-link" href="<?=\yii\helpers\Url::to(['admin/author']);?>" style="text-decoration: underline;"><img src="/img/left.png" alt="Back" width="40" height="40"></a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 7%;" >
        <div class="container-fluid">
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
            <div class="row mt-5">
                <button id="upd_b" type="submit" class="btn btn-primary mt-2" style="background-color: #008c6c; border-color:#008c6c;">Зберегти</button>
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
        $('#last_name_add').val('" . $author->second_name . "');
        $('#first_name_add').val('" . $author->first_name . "');
        $('#middle_name_add').val('" . $author->middle_name . "');
        $('#pseudonym_add').val('" . $author->pseudonym . "');
    });
", View::POS_READY);

$this->registerJs("
    $('#upd_b').click(function(e){
        e.preventDefault();
        var last_name = $('#last_name_add').val();
        var first_name = $('#first_name_add').val();
        var middle_name = $('#middle_name_add').val();
        var pseudonym = $('#pseudonym_add').val();

        
        $.ajax({
            url: '" . \yii\helpers\Url::to(['admin/author-edit', 'id' => $author->id]) . "',
            type: 'post',
            dataType: 'json',
            data: {
                second_name: last_name,
                first_name: first_name,
                middle_name: middle_name,
                pseudonym: pseudonym,
            },
            success: function(response) {
                if(response.status === 'success') {
                    window.location.href = '" . \yii\helpers\Url::to(['admin/author']) . "';
                }
            }
        });
    });
", View::POS_READY);