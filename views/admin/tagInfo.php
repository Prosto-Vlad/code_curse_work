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
                    <a class="nav-link" href="<?=\yii\helpers\Url::to(['admin/tag']);?>" style="text-decoration: underline;"><img src="/img/left.png" alt="Back" width="40" height="40"></a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 7%;" >
        <div class="container-fluid">
            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="name" class="form-label">Назва</label>
                        <input type="text" class="form-control" id="name">
                        </div>
                    </div>
                </div>
            
                <div>
                    <input class="form-check-input" type="checkbox" value="" id="notAvailable">
                    <label class="form-check-label" for="notAvailable">
                        Не доступний
                    </label>
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
        $('#name').val('" . $tag->name . "');

        $('#notAvailable').prop('checked', " . (Json::encode(!$tag->enabled)) . ");
    });
", View::POS_READY);

$this->registerJs("
    $('#upd_b').click(function(e){
        e.preventDefault();
        var name = $('#name').val();
        var notAvailable = $('#notAvailable').prop('checked');
        
        $.ajax({
            url: '" . \yii\helpers\Url::to(['admin/tag-edit', 'id' => $tag->id]) . "',
            type: 'post',
            dataType: 'json',
            data: {
                name: name,
                notAvailable: notAvailable
            },
            success: function(response) {
                
            }
        });
    });
", View::POS_READY);