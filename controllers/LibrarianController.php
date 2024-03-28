<?php

namespace app\controllers;

use Yii;

use yii\web\Controller;
use yii\web\Response;
use yii\web\ForbiddenHttpException;

use yii\helpers\Url;

use yii\filters\AccessControl;

use app\models\Worker;
use app\models\Book;
use app\models\BookTag;
use app\models\History;
use app\models\Reader;
use app\models\Write_off;

use yii\helpers\Json;

class LibrarianController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'denyCallback' => function ($rule, $action) {
                        return Yii::$app->response->redirect(['login/index']);
                        },
                        'matchCallback' => function ($rule, $action) {
                            return Worker::isLibrarian();
                        },
                    ],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('catalog');
    }

    public function actionCatalog()
    {
        return $this->render('catalog');
    }
    public function actionFound()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $bookName = Yii::$app->request->post('bookName');
        $author = Yii::$app->request->post('author');
        $publisher = Yii::$app->request->post('publisher');
        $publishYear = Yii::$app->request->post('publishYear');
        $tags = Yii::$app->request->post('tags');

        $archived = Yii::$app->request->post('archived');
        $notAvailable = Yii::$app->request->post('notAvailable');
        $onHand = Yii::$app->request->post('onHand');

        $books = Book::getFilter($bookName, $author, $publisher, $publishYear, $tags, $archived, $notAvailable, $onHand);

        return ['books' => $books];
    }

    public function actionAdd()
    {
        return $this->render('catalogAdd');
    }

    public function actionCatalogAdd()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $name = Yii::$app->request->post('name');
        $publisher = Yii::$app->request->post('publisher');
        $author = Yii::$app->request->post('author');
        $publishYear = Yii::$app->request->post('publishYear');
        $tags = Yii::$app->request->post('tags');

        $book = new Book();
        $book->name = $name;
        $book->publisher_id = $publisher;
        $book->author_id = $author;
        $book->year_of_publication = $publishYear;
        $book->is_on_hand = false;
        $book->archive = false;
        $book->enabled = true;
        $book->save();

        if (!empty($tags)) {
            foreach ($tags as $tagId) {
                $bookTag = new BookTag();
                $bookTag->book_id = $book->id;
                $bookTag->tag_id = $tagId;
                $bookTag->save();
            }
        }

        return ['status' => 'success'];
    }

    public function actionInfo($id)
    {
        $book = Book::findOne($id);
        $tags = $book->tags;
        $readers = $book->readers;

        $history = History::getByBookId($id);

        return $this->render('info', ['book' => $book, 'tags' => $tags, 'readers' => $readers, 'history' => $history]);
    }

    public function actionEdit($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $name = Yii::$app->request->post('bookName');
        $publisher_id = Yii::$app->request->post('publisher');
        $author_id = Yii::$app->request->post('author');
        $publishYear = Yii::$app->request->post('publishYear');
        $tags = Yii::$app->request->post('tags');
        $is_on_hand = Yii::$app->request->post('onHand');
        $archive = Yii::$app->request->post('archived');
        $enabled = Yii::$app->request->post('notAvailable');

        Book::edit($id, $name, $author_id, $publisher_id, $publishYear, $tags, $archive, $enabled, $is_on_hand);
        return ['status' => 'success'];
    }


    public function actionTakeof()
    {
        return $this->render('takeof');
    }

    public function actionGive($id){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $first_name = Yii::$app->request->post('first_name');
        $middle_name = Yii::$app->request->post('middle_name');
        $second_name = Yii::$app->request->post('second_name');
        $phone_number = Yii::$app->request->post('phone_number');
        $promised_date = Yii::$app->request->post('promised_date');
        $desk = Yii::$app->request->post('desk');

        $reader = Reader::getOne($first_name, $middle_name, $second_name, $phone_number);


        if($reader == null){
            $reader = new Reader();
            $reader->first_name = $first_name;
            $reader->middle_name = $middle_name;
            $reader->second_name = $second_name;
            $reader->phone_number = $phone_number;
            $reader->save();
        } else {
            $reader = Reader::getOne($first_name, $middle_name, $second_name, $phone_number);
        }
        
        History::give($id, $reader->id, $promised_date, $desk);

        $book = Book::findOne($id);
        $book->is_on_hand = true;
        $book->save();
    }

    public function actionBack($id){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        History::back($id);

        $book = Book::findOne($id);
        $book->is_on_hand = false;
        $book->save();
    }

    public function actionWriteoff($id){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $desk = Yii::$app->request->post('desk');

        $write_off = new Write_off();
        $write_off->book_id = $id;
        $write_off->comment = $desk;
        $write_off->save();
    }
}