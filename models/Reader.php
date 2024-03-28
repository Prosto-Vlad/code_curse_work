<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Reader extends ActiveRecord
{
    public static function getOne($first_name, $middle_name, $second_name, $phone_number){
        return self::find()
        ->where(['first_name' => $first_name])
        ->andWhere(['middle_name' => $middle_name])
        ->andWhere(['second_name' => $second_name])
        ->andWhere(['phone_number' => $phone_number])
        ->one(); 
            
    }

    public static function getAll(){
        return self::find()->all();
    }

    public static function add($first_name, $middle_name, $second_name, $phone_number){
        $reader = new Reader();
        $reader->first_name = $first_name;
        $reader->middle_name = $middle_name;
        $reader->second_name = $second_name;
        $reader->phone_number = $phone_number;
        $reader->save();
    }
    
}