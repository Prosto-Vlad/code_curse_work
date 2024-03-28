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
use app\models\Publisher;
use app\models\Author;
use app\models\Tag_t;


use yii\db\Query;

use yii\helpers\Json;

class AdminController extends Controller
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
                            return Worker::isAdmin();
                        },
                    ],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('writeoff');
    }

    public function actionWriteoff()
    {
        return $this->render('writeoff');
    }
    
    //TAG----------------------------------------------------------------------------------------------------------------
    public function actionTag()
    {
        return $this->render('tag');
    }

    public function actionTagout()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $name = Yii::$app->request->post('name');
        $enabled = Yii::$app->request->post('available');

        $tag = Tag_t::getFilter($name, $enabled);

        return ['tags' => $tag];
        
    }

    public function actionTagInfo($id)
    {
        $tag = Tag_t::getOne($id);

        return $this->render('tagInfo', ['tag' => $tag]);
    }

    public function actionTagEdit($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $name = Yii::$app->request->post('name');
        $enabled = Yii::$app->request->post('notAvailable');

        Tag_t::edit($id, $name, $enabled);
        return ['status' => 'success'];
    }

    public function actionTagAdd()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $name = Yii::$app->request->post('name');

        Tag_t::add($name);
        return ['status' => 'success'];
    }

    //WORKER----------------------------------------------------------------------------------------------------------------
    public function actionWorker()
    {
        return $this->render('worker');
    }

    public function actionWorkerout()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $first_name = Yii::$app->request->post('first_name');
        $middle_name = Yii::$app->request->post('middle_name');
        $second_name = Yii::$app->request->post('second_name');
        $phone_number = Yii::$app->request->post('phone_number');
        $birthday = Yii::$app->request->post('birthday');
        $role_id = Yii::$app->request->post('role_id');

        $role_id = trim($role_id);  

        $workers = Worker::getFilter($first_name, $middle_name, $second_name, $phone_number, $birthday, $role_id);

        return ['workers' => $workers];
        
    }

    public function actionWorkerInfo($id)
    {
        $worker = Worker::getOne($id);

        return $this->render('workerInfo', ['worker' => $worker]);
    }

    public function actionWorkerEdit($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $first_name = Yii::$app->request->post('first_name');
        $middle_name = Yii::$app->request->post('middle_name');
        $second_name = Yii::$app->request->post('second_name');
        $phone_number = Yii::$app->request->post('phone_number');
        $birthday = Yii::$app->request->post('birthday');
        $role_id = Yii::$app->request->post('role_id');
        $login = Yii::$app->request->post('login');
        $password = Yii::$app->request->post('password');


        Worker::edit($id, $first_name, $middle_name, $second_name , $phone_number, $birthday, $role_id, $login, $password);
        return ['status' => 'success'];
    }

    public function actionWorkerAdd()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $first_name = Yii::$app->request->post('first_name');
        $middle_name = Yii::$app->request->post('middle_name');
        $second_name = Yii::$app->request->post('second_name');
        $phone_number = Yii::$app->request->post('phone_number');
        $birthday = Yii::$app->request->post('birthday');
        $role_id = Yii::$app->request->post('role_id');
        $login = Yii::$app->request->post('login');
        $password = Yii::$app->request->post('password');



        Worker::add($first_name, $middle_name, $second_name , $phone_number, $birthday, $role_id, $login, $password);
        return ['status' => 'success'];
    }

    //PUBLISHER----------------------------------------------------------------------------------------------------------------
    public function actionPublisher()
    {
        return $this->render('publisher');
    }

    public function actionPublisherout()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $name = Yii::$app->request->post('name');

        $publisher = Publisher::getFilter($name);

        return ['publishers' => $publisher];
        
    }

    public function actionPublisherInfo($id)
    {
        $publisher = Publisher::getOne($id);

        return $this->render('publisherInfo', ['publisher' => $publisher]);
    }

    public function actionPublisherEdit($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $name = Yii::$app->request->post('name');

        Publisher::edit($id, $name);
        return ['status' => 'success'];
    }

    public function actionPublisherAdd()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $name = Yii::$app->request->post('name');

        Publisher::add($name);
        return ['status' => 'success'];
    }

    //AUTHOR----------------------------------------------------------------------------------------------------------------
    public function actionAuthor()
    {
        return $this->render('author');
    }

    public function actionAuthorout()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $first_name = Yii::$app->request->post('first_name');
        $middle_name = Yii::$app->request->post('middle_name');
        $second_name = Yii::$app->request->post('second_name');
        $pseudonym = Yii::$app->request->post('pseudonym');

        $authors = Author::getFilter($first_name, $middle_name, $second_name, $pseudonym);

        return ['authors' => $authors];
        
    }

    public function actionAuthorInfo($id)
    {
        $author = Author::getOne($id);

        return $this->render('authorInfo', ['author' => $author]);
    }

    public function actionAuthorEdit($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $first_name = Yii::$app->request->post('first_name');
        $middle_name = Yii::$app->request->post('middle_name');
        $second_name = Yii::$app->request->post('second_name');
        $pseudonym = Yii::$app->request->post('pseudonym');

        Author::edit($id, $first_name, $middle_name, $second_name, $pseudonym);
        return ['status' => 'success'];
    }

    public function actionAuthorAdd()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $first_name = Yii::$app->request->post('first_name');
        $middle_name = Yii::$app->request->post('middle_name');
        $second_name = Yii::$app->request->post('second_name');
        $pseudonym = Yii::$app->request->post('pseudonym');


        Author::add($first_name, $middle_name, $second_name, $pseudonym);
        return ['status' => 'success'];
    }

    //----------------------------------------------------------------------------------------------------------------
    public function actionOutoff()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $write_off = Write_off::getAll();

        return ['write' => $write_off];
    }

    public function actionAgree($id)
    {
        $write_off = Write_off::findOne($id);

        $book = Book::findOne($write_off->book_id);
        $book->archive = true;
        $book->save();

        $write_off->delete();
        
        return $this->render('writeoff');
    }

    public function actionDisagree($id)
    {
        $write_off = Write_off::findOne($id);
        $write_off->delete();
        
        return $this->render('writeoff');
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
}