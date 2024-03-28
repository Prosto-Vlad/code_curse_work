<?php

namespace app\models;

use yii\db\ActiveRecord;

use app\models\Author;
use app\models\Publisher;
use app\models\Tag_t;
use app\models\BookTag;
use yii\db\Query;

class Book extends ActiveRecord{

    public static function getAll(){
        return self::find()->all();
    }

    public function getAuthor()
    {
        return $this->hasOne(Author::className(), ['id' => 'author_id']);
    }

    public function getPublisher()
    {
        return $this->hasOne(Publisher::className(), ['id' => 'publisher_id']);
    }

    public function getBookTag()
    {
        return $this->hasMany(BookTag::className(), ['book_id' => 'id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag_t::className(), ['id' => 'tag_id'])
                    ->via('bookTag');
    }

        public function getReaders()
    {
        return $this->hasMany(Reader::class, ['ID' => 'reader_id'])
            ->viaTable('history', ['book_id' => 'ID']);
    }

    public static function getFilter($name, $author_id, $publisher_id, $date, $tags, $archived, $notAvailable, $onHand){
        $query = (new Query())
            ->select(['book.*', 'author.first_name', 'author.middle_name', 'author.second_name', 'author.pseudonym', 'publisher.name as publisher_name'])
            ->from('book');

        $query->innerJoin('author', 'author.id = book.author_id');
        $query->innerJoin('publisher', 'publisher.id = book.publisher_id');
        
        if ($archived == 'true') {
            $query->andWhere(['archive' => true]);
        }
        else {
            $query->andWhere(['archive' => false]);
        }

        if ($onHand == 'true') {
            $query->andWhere(['is_on_hand' => true]);
        }
        else {
            $query->andWhere(['is_on_hand' => false]);
        }

        if ($notAvailable == 'true') {
            $query->andWhere(['book.enabled' => false]);
        }
        else {
            $query->andWhere(['book.enabled' => true]);
        }

        if (!empty($name)) {
            $query->andWhere(['like', 'book.name', $name]);
        }

        if (!empty($author_id)) {
            $query->andWhere(['author_id' => $author_id]);
        }

        if (!empty($publisher_id)) {
            $query->andWhere(['publisher_id' => $publisher_id]);
        }

        if (!empty($date)) {
            $query->andWhere(['year_of_publication' => $date]);
        }

        if (!empty($tags)) {
            $query->innerJoin('book_tag', 'book_tag.book_id = book.id')
                ->innerJoin('tag_t', 'tag_t.id = book_tag.tag_id')
                ->andWhere(['tag_t.id' => $tags]);
        }

        $query->distinct();
        return $query->all();
    }

    public static function findOne($id){
        return self::find()->where(['id' => $id])->one();
    }

    public static function edit($id, $name, $author_id, $publisher_id, $date, $tags, $archived, $notAvailable, $onHand){
        $book = Book::findOne($id);

        $book->name = $name;
        $book->author_id = $author_id;
        $book->publisher_id = $publisher_id;
        $book->year_of_publication = $date;

        $archivedBool = ($archived === 'true');
        $notAvailableBool = ($notAvailable === 'true');
        $onHandBool = ($onHand === 'true');

        $book->archive = $archivedBool;
        $book->enabled = !$notAvailableBool;
        $book->is_on_hand = $onHandBool;

        
        
        $book->save();

        BookTag::deleteAll(['book_id' => $id]);
        if (!empty($tags)) {
            foreach ($tags as $tag_id) {
                $bookTag = new BookTag();
                $bookTag->book_id = $id;
                $bookTag->tag_id = $tag_id;
                $bookTag->save();
            }
        }
    }
}