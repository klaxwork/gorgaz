<?php

namespace frontend\controllers;

use common\models\ar_inherit\Reasons;
use common\models\Book;
use common\models\CustomerNode;
use common\models\ElSearchFilter;
use common\models\models\EcmProducts;
use frontend\components\FrontendController;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\db\Expression;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\models\CmsTree;
use common\components\M;
use common\models\ElSearch;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use yii\web\Cookie;

/**
 * Site controller
 */
class SiteController extends FrontendController
{

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionCreateIndex() {
        return '';
    }

    public function actionFillIndex() {
        return '';
    }

    public function actionIndex() {
        $this->layout = 'clear2';
        M::printr($this->layout, '$this->layout');

        exit;
        M::printr('111');
        $cache = Yii::$app->cache;
        $id = 200;
        $key = 'category_' . $id;
        $expire = 3600 * 24 * 7; // 1 week
        $dependency = new \yii\caching\DbDependency(['sql' => 'SELECT MAX(dt_updated) FROM cms_tree']);

        $res = Yii::$app->cache->getOrSet(
            $key,
            function () {
                $data = ['foo' => 'bar3'];
                return $data;
            },
            $expire,
            $dependency
        );
        M::printr($res, '$res');

        exit;

        $redis = Yii::$app->redis;
        //M::printr($redis, '$redis');

        $value = 'test01';
        $redis->setValue('test01', $value);
        M::printr($redis, '$redis');

        //$value = $redis->getValue('test');
        //M::printr($value, '$value');
        return false;

        $dependency = [
            'class' => 'yii\caching\DbDependency',
            'sql' => 'SELECT COUNT(*) FROM {{%cms_tree}}',
        ];
        if ($this->beginCache('LcommentsWidget', ['dependency' => $dependency])) {
            echo common\widgets\LcommentsWidget::widget();
            $this->endCache();
        }
        exit;

        $this->layout = '';
        $x = null;
        $x = Yii::$app->elasticsearch;
        M::printr($x, '$x');
        exit;
    }

    public function actionTestmail() {
        if (0) {
            Yii::$app->mailer->compose()
                ->setFrom('info@nays.ru')
                ->setTo('klaxwork@mail.ru')
                ->setSubject('$form->subject')
                ->setTextBody('Текст сообщения')
                ->send();
        }

        if (0) {
            $oMailer = Yii::$app->mailer->compose();
            M::printr($oMailer, '$oMailer');

            $oMailer->setFrom('info@nays.ru');
            $oMailer->setTo('klaxwork@mail.ru');
            $oMailer->setSubject('Тема сообщения');
            $oMailer->setTextBody('Текст сообщения');
            $oMailer->setHtmlBody('<b>текст сообщения в формате HTML</b>');
            $res = $oMailer->send();
            M::printr($res, '$res');
        }

        if (0) {
            $oMyMailer = Yii::$app->mymailer;
            M::printr($oMyMailer, '$oMailer');

            $result = M::sendEmail('klaxwork@yandex.ru', 'klaxwork@yandex.ru', 'klaxwork@yandex.ru');
            M::printr($result, 'klaxwork@yandex.ru');

            $result = M::sendEmail('klaxwork@mail.ru', 'klaxwork@mail.ru', 'klaxwork@mail.ru');
            M::printr($result, 'klaxwork@mail.ru');
        }

        if (0) {
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output

                //Recipients
                $mail->setFrom('klaxwork.dn@gmail.com', 'Klaxwork');
                $mail->addAddress('klaxwork@mail.ru', 'Klaxwork');     // Add a recipient
                $mail->addAddress('klaxwork@yandex.ru');               // Name is optional
                $mail->addReplyTo('klaxwork@mail.ru', 'Information');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');

                // Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Here is the subject';
                $mail->Body = 'This is the HTML message body <b>in bold!</b>';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $res = $mail->send();
                M::printr($res, '$res');
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }

        //1
        if (1) {
            //$mails = Yii::$app->params['emails'];
            //M::printr($mails, '$mails');
            $result = M::sendEmail('dmytrich87@gmail.com', 'Это текст письма, отправленного с сайта...', 'Пробное письмо с сайта');
            M::printr($result, '$result');
        }

    }

    public function actionIndex3() {
        exit;
        $tree = 0;
        if ($tree) {
            M::printr($tree, '$tree');

            $root = CmsTree::find()->where(['id' => 1])->roots()->one();
            M::printr($root, '$root');
            $t2 = new Tree(['node_name' => 'aaa2']);
            $t2->appendTo($root);
            M::printr($t2);
        }

        $index = 'fish_filter_test_filter_products';
        M::printr($index, '$index');
        $type = 'productFilter';
        M::printr($type, '$type');

        $request = '#016 Blue Mint';
        $request = str_replace(['.', ',', '-', ' '], '', strtolower($request));

        $filter = 1;
        if ($filter) {
            $tm1 = microtime(true);
            $query = ElSearchFilter::find();
            $query->index = $index;
            $query->type = $type;
            $query->limit(1);
            //$query->offset = 0;
            //*/
            $f1 = [
                [
                    'range' => [
                        'price' => [
                            'gte' => 0,
                        ],
                    ]
                ],
                [
                    'range' => [
                        'ns_left_key' => [
                            'gte' => 200,
                        ],
                    ],
                ],
                [
                    'range' => [
                        'zaglublenie_m.min' => [
                            'gte' => 3,
                        ],
                    ],
                ],
            ];
            $f2 = [
                [
                    'range' => [
                        'price' => [
                            'gte' => 0,
                        ],
                    ]
                ],
                [
                    'range' => [
                        'ns_left_key' => [
                            'gte' => 850,
                            'lte' => 9623,
                        ],
                    ],
                ],
            ];
            $query->query(
                [
                    'bool' => [
                        'filter' => $f2
                    ],
                ]
            );
            //*/
            //$query->query(Json::decode('{"bool":{"filter":[{"range":{"price":{"gte":0}}},{"range":{"ns_left_key":{"gte":850,"lte":9623}}}]}}'));
            $query->orderBy('is_price DESC, price ASC');

            $query->limit(10000);
            $resAll = $query->asArray()->all();
            M::printr(count($resAll), 'count($resAll)');
            $tm2 = microtime(true);
            M::printr($tm2 - $tm1, '$tm2 - $tm1');
            foreach ($resAll as $x) {
                //M::printr($x->attributes, '$x->attributes');
            }
            M::printr($resAll, '$resAll');
            exit;

            $limit = 5;
            $offset = 0;

            $result = [];
            foreach ($query->each() as $item) {
                M::printr($item, count($result) . ' $item');
                if (0) {
                    if (empty($result[$item->category])) {
                        $result[$item->category] = $item;
                    }
                    if (0 < $item->price && $item->price < $result[$item->category]->price) {
                        $result[$item->category] = $item;
                    }
                    if (count($result) >= ($limit + $offset)) break;
                }
            }
            $tm2 = microtime(true);
            M::printr($tm2 - $tm1, '$tm2 - $tm1');

            $tm2 = microtime(true);
            M::printr($tm2 - $tm1, '$tm2 - $tm1');
            //M::printr($resAll, '$resAll');
            foreach ($resAll as $res) {
                M::printr($res->catalog, '$res->catalog');
                M::printr($res->attributes, '$res->attributes');
                M::printr($res->getScore(), '$res->getScore()');
                print "<br>";
            }
            //M::printr($resAll, '$resAll');
        }


        $create = 0;
        if ($create) {
            M::printr($create, '$create');
            //$book = new Book();
            ElSearch::deleteIndex();
            ElSearch::createIndex();
        }

        $fill = 0;
        if ($fill) {
            M::printr($fill, '$fill');
            $oProducts = EcmProducts::find()
                ->limit(20)
                ->orderBy('id ASC')
                ->offset('70')
                ->all();
            $c = 0;
            foreach ($oProducts as $oProduct) {
                $c++;

                //M::printr($oProduct->attributes, '$oProduct->attributes');
                $name = strtolower($oProduct->product_name);
                $oVendor = $oProduct->getField('1c_product_vendor');
                $vendor = strtolower($oVendor->field_value);
                M::printr($oProduct->id, '$oProduct->id');
                M::printr($vendor, "{$c}");
                //if (empty($oVendor->field_value)) continue;

                $elsearch = new ElSearch();
                $elsearch->index = ElSearch::index();
                $elsearch->type = ElSearch::type();

                $elsearch->primaryKey = $oProduct->id;
                $elsearch->product_id = $oProduct->id;
                $elsearch->catalog = $oProduct->id;
                $elsearch->vendor = $vendor;

                $name = str_replace(['/', ',', '.'], '', $name);
                $elsearch->name = $name;

                $elsearch->save();
            }
        }

        $s1 = 0;
        if ($s1) {
            M::printr($s1, '$s1');

            $params = array();
            $params["scroll"] = "30s";
            $params['size'] = 100;
            $params['body']['query']['multi_match']['query'] = $request;

            $params['index'] = ElSearch::index();
            $params['body']['query']['multi_match']['fields'] = ['vendor', 'name^2', 'long_name^3', 'description^4'];
            $params['index'] = ElSearch::type();
            M::printr($params, '$params');

            $dbEl = ElSearch::getDb();
            $command = $dbEl->createCommand();
            //

            //$result_product = $client->search($params);
            //M::printr($result_product, '$result_product');
        }

        $s2 = 0;
        if ($s2) {
            M::printr($s2, '$s2');
            $query = ElSearch::find()
                ->query(["multi_match" => ["query" => $request]]);
            M::printr($query, '$query');
            $elsearch = $query->all();
            M::printr($elsearch, '$elsearch');
        }

        $s3 = 0;
        if ($s3) {
            M::printr($s3, '$s3');
            $query = ElSearch::find();
            $query->query(
                [
                    "multi_match" => [
                        'query' => $request,
                        'fields' => [
                            'vendor',
                            'name^2',
                            'long_name^3',
                            'description^4'
                        ],
                    ],
                ]
            );
            $query->index = 'fish_test_server_products'; //ElSearch::index();
            $query->type = 'product'; //ElSearch::type();

            M::printr($query, '$query');

            $resAll = $query->all();
            foreach ($resAll as $res) {
                M::printr($res->attributes, '$res->attributes');
                M::printr($res->getScore(), '$res->getScore()');
                print "<br>";
            }
            M::printr($resAll, '$resAll');
        }


        if (0) {
            $customer = new CustomerNode();
            $id = (int)rand(0, 10000);
            $customer->primaryKey = $id; // in this case equivalent to $customer->id = 1;
            $customer->setAttributes(['name' => 'qwers']);
            $customer->address = 'blabla';
            //$customer->save();
            M::printr($customer, '$customer');
        }
        if (0) {
            $customer = CustomerNode::get($id); // get a record by pk
            M::printr($customer, '$customer');
        }
        if (0) {
            $customers = CustomerNode::mget([1, 2, 3]); // get multiple records by pk
            M::printr($customers, '$customers');
        }
        if (0) {
            $customer = CustomerNode::find()->where(['product_name' => 'classic'])->one(); // find by query, note that you need to configure mapping for this field in order to find records properly
            M::printr($customer, '$customer');
        }
        if (0) {
            $elsearch = ElSearch::find()
                ->query(
                    [
                        'multi_match' => [
                            'query' => $query,
                            'fields' => [
                                'vendor',
                                'name^2',
                                'long_name^3',
                                'description^4'
                            ],
                        ],
                    ]
                )
                ->all();
            M::printr($elsearch, '$elsearch');
        }

// http://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query.html
//$result = Article::find()->query(["match" => ["title" => "yii"]])->all(); // articles whose title contains "yii"

// https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query.html#query-dsl-match-query-fuzziness
        $this->context->page_title = 'Главная страница';

        $this->render('main');
        exit;
        $x = ElSearch::find()->query(
            ['query_string' => [
                'default_field' => '_all',
                'query' => "*" . classic . "*",
            ]]
        );

        M::printr($x, '$x');
        exit;

        $query = ElSearch::find()->query(
            [
                'match' => [
                    'title' => [
                        'query' => 'This query will return articles that are similar to this text :-)',
                        'operator' => 'and',
                        //'fuzziness' => 'AUTO'
                    ]
                ]
            ]
        );

        $query->all(); // gives you all the documents
// you can add aggregates to your search
        $query->addAggregate('click_stats', ['terms' => ['field' => 'visit_count']]);
        $query->search();

        exit;


        $id = 1572; //1723;
        $oCategory = CmsTree::findOne($id);
        //M::printr($oCategory, '$oCategory');

        $oContent = $oCategory->content;
        //M::printr($oContent, '$oContent');

        $oImgs = $oContent->getImages();
        //M::printr($oImgs, '$oImgs');

        //найти картинку с определенным id
        $oCropped = false;
        if (!empty($oImgs[0])) {
            $oImg = $oImgs[0];
            $oCropped = $oImg->getCropped('qw:teaser_big');
        }

        return $this->render(
            'index',
            [
                'oCategory' => $oCategory,
                'oContent' => $oContent,
                'oCropped' => $oCropped
            ]
        );
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex2() {
        //$root = CmsTree::find()->where(['id' => 1])->roots()->one();
        //M::printr($root, '$root');
        //$t2 = new Tree(['node_name' => 'aaa2']);
        //$t2->appendTo($root);
        //M::printr($t2);
        return $this->render('index2');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render(
                'login', [
                    'model' => $model,
                ]
            );
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render(
                'contact', [
                    'model' => $model,
                ]
            );
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout() {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render(
            'signup', [
                'model' => $model,
            ]
        );
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render(
            'requestPasswordResetToken', [
                'model' => $model,
            ]
        );
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render(
            'resetPassword', [
                'model' => $model,
            ]
        );
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token) {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail() {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render(
            'resendVerificationEmail', [
                'model' => $model
            ]
        );
    }

    public function actionDebugOn() {
        $cookies = Yii::$app->response->cookies;
        $debugCookie = new Cookie([
                'name' => 'debug',
                'value' => 1,
                'expire' => time() + 60 * 60 * 24 * 365,
            ]
        );
        $cookies->add($debugCookie);
        M::printr($cookies, '$cookies');
        exit;

        if (0) {
            $cookie = new Cookie('debug');
            $cookie->expire = time() + 60 * 60 * 24 * 365; //1 year
            Yii::$app->request->cookies['debug'] = $cookie;
            if (isset(Yii::$app->request->cookies['debug'])) {
                $cookie = Yii::$app->request->cookies['debug']->value;
            } else {
                $cookie = new Cookie('debug');
                $cookie->expire = time() + 60 * 60 * 24 * 365; //1 year
                Yii::$app->request->cookies['debug'] = $cookie;
            }
        }
    }

    public function actionDebugOff() {
        $cookies = Yii::$app->response->cookies;
        $debugCookie = new Cookie([
                'name' => 'debug',
                'value' => 0,
                'expire' => time() + 60 * 60 * 24 * 365,
            ]
        );
        $cookies->add($debugCookie);
        M::printr($cookies, '$cookies');

        if (0) {
            $cookie = new Cookie('debug');
            $cookie->expire = time() + 60 * 60 * 24 * 365; //1 year
            Yii::$app->request->cookies['debug'] = $cookie;
        }
    }

    public function actionFillbase() {
        $storage = \Yii::getAlias('@storage');
        M::printr($storage, '$storage');

        //занести типы в БД
        if (0) {
            $f = fopen("{$storage}/.preload/types.csv", 'r');
            while (!feof($f)) {
                $type = fgetcsv($f, 1000, ';');
                M::printr($type, '$type');
                $oType = new EquipmentTypes();
                $oType->type_name = trim($type[0]);
                if (!empty($oType->type_name)) {
                    if (!$oType->save()) {
                        throw new Exception("Can`t save type [{$oType->type_name}]");
                    }
                }
            }
            fclose($f);
        }
        //$oTypes = EquipmentTypes::find()->all();
        //M::printr($oTypes, '$oTypes');

        //занести модели в БД
        if (0) {
            $f = fopen("{$storage}/.preload/models.csv", 'r');
            //пройтись по моделям в файле
            while (!feof($f)) {
                $item = fgetcsv($f, 1000, ';');
                M::printr($item, '$item');
                $model = $item[0];
                M::printr($model, '$model');
                $type = $item[1];
                M::printr($type, '$type');
                $oType = EquipmentTypes::find()->where(['type_name' => $type])->one();
                //M::printr($oType, '$oType');
                if (empty($oType)) {
                    $oType = new EquipmentTypes();
                    $oType->type_name = trim($type);
                    if (!empty($oType->type_name)) {
                        if (!$oType->save()) {
                            throw new Exception("Can`t save type [{$oType->type_name}]");
                        }
                    }
                    $oType = EquipmentTypes::find()->where(['type_name' => $type])->one();
                }

                $oModel = new EquipmentModels();
                $oModel->model_name = trim($model);
                $oModel->equipment_types_ref = $oType->id;
                if (!$oModel->save()) {
                    throw new Exception("Can`t save [{$oModel->model_name}]");
                }
            }
            fclose($f);
        }

        //занести причины в БД
        if (1) {
            $f = fopen("{$storage}/.preload/reasons.csv", 'r');
            while (!feof($f)) {
                $reason = fgets($f, 1000);
                M::printr($reason, '$reason');
                $oReason = new Reasons();
                $oReason->reason_name = trim($reason);
                if (!empty($oReason->reason_name)) {
                    if (!$oReason->save()) {
                        throw new Exception("Can`t save reason [{$oReason->reason_name}]");
                    }
                }
            }
            fclose($f);
        }

        //занести статусы в БД
        if (0) {
            $f = fopen("{$storage}/.preload/types.csv", 'r');
            while (!feof($f)) {
                $type = fgetcsv($f, 1000, ';');
                M::printr($type, '$type');
                $oType = new EquipmentTypes();
                $oType->type_name = trim($type[0]);
                if (!empty($oType->type_name)) {
                    if (!$oType->save()) {
                        throw new Exception("Can`t save type [{$oType->type_name}]");
                    }
                }
            }
            fclose($f);
        }

    }
}
