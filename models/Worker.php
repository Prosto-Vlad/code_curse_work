<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Worker extends ActiveRecord implements IdentityInterface
{
    const ROLE_ADMIN = 2;
    const ROLE_LIBRARIAN = 1;

    public static function isLibrarian()
    {
        return Yii::$app->user->identity->role_id == self::ROLE_LIBRARIAN;
    }

    public static function isAdmin()
    {
        return Yii::$app->user->identity->role_id == self::ROLE_ADMIN;
    }
    
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return null;
    }

    public static function getAll(){
        return self::find()->all();
    }

    public static function getOne($id){
        return self::findOne($id);
    }

    public static function add($first_name, $middle_name, $second_name , $phone_number, $birthday, $role_id, $login, $password){
        $worker = new Worker();
        $worker->first_name = $first_name;
        $worker->middle_name = $middle_name;
        $worker->second_name = $second_name;
        $worker->phone_number = $phone_number;
        $worker->birthd_date = $birthday;
        $worker->role_id = $role_id;
        $worker->login = $login;
        $worker->password = md5($password);
        $worker->save();
    }

    public static function edit($id, $first_name, $middle_name, $second_name , $phone_number, $birthday, $role_id, $login, $password){
        $worker = self::getOne($id);

        $worker->first_name = $first_name;
        $worker->middle_name = $middle_name;
        $worker->second_name = $second_name;
        $worker->phone_number = $phone_number;
        $worker->birthd_date = $birthday;
        $worker->role_id = $role_id;
        $worker->login = $login;
        if($password != '') 
        {
            $worker->password = $password;
        }

        $worker->save();
    }

    public static function getFilter($first_name, $middle_name, $second_name, $phone_number, $birthday, $role_id){
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
        if($phone_number){
            $query->andWhere(['like', 'phone_number', $phone_number]);
        }
        if($birthday){
            $query->andWhere(['like', 'birthday', $birthday]);
        }
        if($role_id){
            $query->andWhere(['role_id' => $role_id]);
        }
        return $query->all();
    }
}

