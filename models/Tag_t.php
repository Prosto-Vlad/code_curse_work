<?php

namespace app\models;

use yii\db\ActiveRecord;

class Tag_t extends ActiveRecord{

    public function getTag()
    {
        return $this->hasOne(Tag_t::className(), ['id' => 'tag_id']);
    }

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
        $tag = new Tag_t();
        $tag->name = $name;
        $tag->enabled = true;
        $tag->save();
    }

    public static function edit($id, $name, $enabled){
        $tag = self::getOne($id);
        $tag->name = $name;
        $enavleBool = !($enabled === 'true');
        $tag->enabled = $enavleBool;
        $tag->save();
    }

    public static function getFilter($name, $enabled){
        $query = self::find();
        if($name){
            $query->andWhere(['like', 'name', $name]);
        }
        if($enabled == 'true'){
            $query->andWhere(['enabled' => false]);
        }
        else
        {
            $query->andWhere(['enabled' => true]);
        }
        return $query->all();
    }
}