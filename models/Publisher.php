<?php

namespace app\models;

use yii\db\ActiveRecord;

class Publisher extends ActiveRecord{
    

    public static function getAll(){
        return self::find()->all();
    }

    public static function getAllEnabled(){
        return self::find()->where(['enabled' => true])->all();
    }

    public static function getOne($id){
        return self::findOne($id);
    }

    public static function add($name){
        $publisher = new Publisher();
        $publisher->name = $name;
        $publisher->save();
    }

    public static function edit($id, $name){
        $publisher = self::getOne($id);
        $publisher->name = $name;
        $publisher->save();
    }

    public static function getFilter($name){
        $query = self::find();
        if($name){
            $query->andWhere(['like', 'name', $name]);
        }
        return $query->all();
    }
}