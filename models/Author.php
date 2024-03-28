<?php

namespace app\models;

use yii\db\ActiveRecord;

class Author extends ActiveRecord{
    
    public static function getAll(){
        return self::find()->all();
    }

    public static function getOne($id){
        return self::findOne($id);
    }

    public static function add($first_name, $middle_name, $second_name, $pseudonym){
        $author = new Author();
        
        $author->first_name = $first_name;
        $author->middle_name = $middle_name;
        $author->second_name = $second_name;
        $author->pseudonym = $pseudonym;

        $author->save();
    }

    public static function edit($id, $first_name, $middle_name, $second_name, $pseudonym){
        $author = self::getOne($id);

        $author->first_name = $first_name;
        $author->middle_name = $middle_name;
        $author->second_name = $second_name;
        $author->pseudonym = $pseudonym;

        $author->save();
    }

    public static function getFilter($first_name, $middle_name, $second_name, $pseudonym){
        $query = self::find();
        if($first_name){
            $query->andWhere(['like', 'first_name', $first_name]);
        }
        if($middle_name){
            $query->andWhere(['like', 'middle_name', $middle_name]);
        }
        if($second_name){
            $query->andWhere(['like', 'second_name', $second_name]);
        }
        if($pseudonym){
            $query->andWhere(['like', 'pseudonym', $pseudonym]);
        }
        return $query->all();
    }

}