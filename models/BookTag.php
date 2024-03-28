<?php

namespace app\models;

use yii\db\ActiveRecord;

class BookTag extends ActiveRecord{
    
    public static function getAll(){
        return self::find()->all();
    }
}