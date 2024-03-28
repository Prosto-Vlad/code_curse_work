<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;

class History extends ActiveRecord
{

    public function getReader()
    {
        return $this->hasOne(Reader::className(), ['id' => 'reader_id']);
    }

    public function getBook()
    {
        return $this->hasOne(Book::className(), ['id' => 'book_id']);
    }

    public static function getAll(){
        return self::find()->all();
    }

    public static function getByBookId($book_id){
            $query = (new Query())
                ->select(['history.*', 'reader.first_name', 'reader.middle_name', 'reader.second_name', 'reader.phone_number'])
                ->from('history')
                ->where(['book_id' => $book_id])
                ->innerJoin('reader', 'reader.id = history.reader_id')
                ->orderBy(['id' => SORT_DESC]);

    return $query->all();
    }

    public static function getFilter($book_id, $reader_id = '', $date = '', $return_date = '', $is_returned = ''){
        $query = (new Query())
            ->select(['history.*', 'reader.first_name', 'reader.middle_name', 'reader.second_name', 'reader.phone_number'])
            ->from('history');

        $query->innerJoin('reader', 'reader.id = history.reader_id');
        
        if ($is_returned == 'true') {
            $query->andWhere(['is_returned' => true]);
        }
        else {
            $query->andWhere(['is_returned' => false]);
        }

        if ($reader_id != '') {
            $query->andWhere(['reader_id' => $reader_id]);
        }

        if ($book_id != '') {
            $query->andWhere(['book_id' => $book_id]);
        }

        if ($date != '') {
            $query->andWhere(['date' => $date]);
        }

        if ($return_date != '') {
            $query->andWhere(['return_date' => $return_date]);
        }

        return $query->all();
    }

    public static function give($book_id, $reader_id, $promised_date, $desk = ''){
        $history = new History();
        $history->book_id = $book_id;
        $history->reader_id = $reader_id;
        $history->hand_date = date('Y-m-d');
        $history->promised_date = $promised_date;
        $history->desk = $desk;
        $history->save();
    }

    public static function back($id){
        $history = History::find()
            ->where(['book_id' => $id])
            ->orderBy(['id' => SORT_DESC])
            ->limit(1)
            ->one();
        $history->real_date = date('Y-m-d');
        $history->save();
    }
}