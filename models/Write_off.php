<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;

class Write_off extends ActiveRecord
{
    public static function getAll()
    {
        $query = (new Query()) ->select(['write_off.*', 'write_off.id as wid', 'book.id as id_book', 'book.name as book_name', 'author.*', 'publisher.*', 'book.year_of_publication'])
            ->from('write_off')
            ->innerJoin('book', 'book.id = write_off.book_id')
            ->innerJoin('author', 'author.id = book.author_id')
            ->innerJoin('publisher', 'publisher.id = book.publisher_id');
        return $query->all();
    }
}