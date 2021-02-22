<?php

namespace common\components;

use Yii;
use yii\base\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


/**
 * Created by PhpStorm.
 * User: Pavel
 * Date: 16.07.2015
 * Time: 10:52
 */
class M
{
    public static $month = array(
        '',
        'Январь',
        'Февраль',
        'Март',
        'Апрель',
        'Май',
        'Июнь',
        'Июль',
        'Август',
        'Сентябрь',
        'Октябрь',
        'Ноябрь',
        'Декабрь'
    );

    public static $monthShort = array(
        '',
        'Янв.',
        'Февр.',
        'Мaрта',
        'Апр.',
        'Мая',
        'Июня',
        'Июля',
        'Авг.',
        'Сент.',
        'Окт.',
        'Нояб.',
        'Дек.'
    );

    public static $ofmonth = array(
        '',
        'Января',
        'Февраля',
        'Марта',
        'Апреля',
        'Мая',
        'Июня',
        'Июля',
        'Августа',
        'Сентября',
        'Октября',
        'Ноября',
        'Декабря'
    );

    public static $DayWeek = array(
        'Воскресенье',
        'Понедельник',
        'Вторник',
        'Среда',
        'Четверг',
        'Пятница',
        'Суббота',
        'Воскресенье'
    );

    public static $DayWeekShort = array(
        'Вс',
        'Пн',
        'Вт',
        'Ср',
        'Чт',
        'Пт',
        'Сб',
        'Вс'
    );

    public static function declOfNum($number, $titles, $show = true) {
        $cases = array(2, 0, 1, 1, 1, 2);
        $res = ($show ? $number . " " : '') . $titles[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min(abs($number) % 10, 5)]];
        return $res;
    }

    public static function printr($var = false, $name = false, $toVar = false) {
        $mem = '';
        $display = 'block';
        //if (Yii::app()->user->isGuest) {
        //$display = 'none';
        //}

        //ob_start();
        /*if (!YII_DEBUG) {
            return false;
        }*/

        if (0) {
            ob_start();
            print "<pre style='position: relative; z-index: 999; display: {$display}; font-size: 13px; background-color: #ddd; padding: 5px; border: solid 1px #000; line-height: 1.2em;'>\n";
            if ($name) {
                print "<span style='color: #080; font-weight: bold; font-size: 20px; line-height: 1.2em;'>{$name}</span> => ";
            }
            //$mem .= print_r($var, true);
            CVarDumper::dump($var);
            print "</pre>\n";
            //var_dump($someVar);
            $mem = ob_get_clean();

        }


        if (0) {
            if (!empty($_GET['debug']) && $_GET['debug'] == 'console') {
                if ($name) {
                    $mem .= "{$name} = ";
                }
                $mem .= print_r($var, true);
                $mem .= "\n";
            } else {
                $cookies = Yii::$app->response->cookies;
                $val = $cookies->getValue('debug', false);
                if (!$val) {
                    $display = 'none';
                } else {
                    $display = 'block';
                }
                //$display = 'block';
                $mem .= "<pre style='position: relative; z-index: 999; display: {$display}; font-size: 13px; background-color: #ddd; padding: 5px; border: solid 1px #000; line-height: 1.2em;'>";
                if ($name) {
                    $mem .= "<span style='color: #080; font-weight: bold; font-size: 20px; line-height: 1.2em;'>{$name}</span> => ";
                }
                $mem .= print_r($var, true);
                $mem .= "</pre>\n";
            }
        }

        if (1) {
            if (!empty($_GET['debug']) && $_GET['debug'] == 'console') {
                if ($name) {
                    $mem .= "{$name} = ";
                }
                $mem .= print_r($var, true);
                $mem .= "\n";
            } else {
                $cookies = Yii::$app->response->cookies;
                $cookies = Yii::$app->request->cookies;
                //M::xlog(['$cookies' => $cookies], 'cookies');
                $val = $cookies->getValue('debug', false);
                $val = true;
                if (!$val) {
                    $display = 'none';
                } else {
                    $display = 'block';
                }
                //$display = 'block';
                $mem .= "<pre style='position: relative; z-index: 999; display: {$display}; font-size: 13px; background-color: #ddd; padding: 5px; border: solid 1px #000; line-height: 1.2em;'>";
                if ($name) {
                    $mem .= "<span style='color: #080; font-weight: bold; font-size: 20px; line-height: 1.2em;'>{$name}</span> => ";
                }
                $mem .= print_r($var, true);
                $mem .= "</pre>\n";
            }
        }

        if ($toVar !== false) {
            return $mem;
        } else {
            print $mem;
        }
    }

    public static function debug($var, $name, $is_return) {
        if ($_GET['debug'] == 'console') {
            print '$name => ';
            print_r($var);
            print "\n";
        } elseif (DEBUG) {
            M::printr($var, $name, $is_return);
        }
    }

    public static function toArray($objects, $field = false) {
        $arrays = array();
        foreach ($objects as $element) {
            if ($field) {
                $k = $element->$field;
                $arrays[$k] = $element->attributes;
            } else {
                $arrays[] = $element->attributes;
            }
        }
        return $arrays;
    }

    public static function json_encode($data) {
        if (is_object($data)) {
            $data = array($data);
        }
        foreach ($data as $k => $object) {
            M::printr($object, '$object');
            $relations = $object->relations();

            foreach ($relations as $key_relations => $relation) {
                M::printr($key_relations, '$key_relations');
                $new_object = $object->$key_relations;
                M::printr($new_object, '$new_object');
            }
        }


    }

    public static function DayOfWeek($date = false) {
        if ($date === false) {
            $date = time();
        }

        if ($date === (int)$date) {
            //число
            $day = (int)strftime("%w", $date);
        } else {
            //строка
            $day = (int)strftime("%w", strtotime($date));
        }

        return self::$DayWeek[$day];
    }

    public static function DayOfWeekShort($date = false, $short = false) {
        if ($date === false) {
            $date = time();
        }

        if ($date === (int)$date) {
            //число
            $day = (int)strftime("%w", $date);
        } else {
            //строка
            $day = (int)strftime("%w", strtotime($date));
        }

        return self::$DayWeekShort[$day];
    }

    public static function Month($date = 0) {
        if ($date === 0) {
            $date = time();
        }
        //переводим в число
        if ($date !== (int)$date) {
            $date = strtotime($date);
        }
        //получаем номер месяца
        $mon = (int)strftime("%m", $date);
        //возвращаем месяц
        return self::$month[$mon];
    }

    public static function OfMonth($date = 0, $short = false) {
        if ($date === 0) {
            $date = time();
        }
        //переводим в число
        if ($date !== (int)$date) {
            $date = strtotime($date);
        }
        //получаем номер месяца
        $mon = (int)strftime("%m", $date);
        //возвращаем дату вида число месяца год ("20 декабря" если коротко, или "20 декабря 2015")
        if ($short !== false) {
            return trim(strftime("%e " . self::$ofmonth[$mon], $date));
        } else {
            return trim(strftime("%e " . self::$ofmonth[$mon] . " %Y", $date));
        }
    }

    public static function sendEmail($email, $text, $subject = false, $attachment = false) {
        M::xlog(['$email' => $email, '$text' => $text, '$subject' => $subject]);
        $oMailer = new PHPMailer(true);

        if (1) {
            //Server settings
            //$oMailer->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            //$oMailer->IsSMTP(); // enable SMTP
            $oMailer->mailer = 'smtp';
            $oMailer->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
            $oMailer->SMTPAuth = true;  // authentication enabled
            $oMailer->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
            $oMailer->SMTPAutoTLS = true;
            $oMailer->Host = 'smtp.gmail.com';
            $oMailer->Port = 587;
            $oMailer->isHTML(true);                                  // Set email format to HTML
            $oMailer->Subject = $subject ? $subject : 'test.trest';
            $oMailer->Subject .= strftime(' [%Y-%m-%d %H:%M:%S]');
            $oMailer->CharSet = 'UTF-8';
            $oMailer->Body = $text; //html
            $oMailer->AltBody = $text; //only text without html tags

            $oMailer->Username = 'klaxwork.dn@gmail.com';
            $oMailer->Password = 'E1vWHlfyap';
            //Recipients
            //$mail->setFrom('klaxwork.dn@gmail.com', 'Klaxwork');
            //$oMailer->setFrom(Yii::$app->params['from']['email'], Yii::$app->params['from']['name']);
            //$oMailer->setFrom('klaxwork.dn@gmail.com','Klaxwork');
            $oMailer->From = 'klaxwork.dn@gmail.com';
            $oMailer->FromName = 'Klaxwork';
        }

        if (!is_array($email)) {
            $emails = [$email];
        } else {
            $emails = $email;
        }

        M::xlog(['$emails' => $emails]);
        if (1) {
            foreach ($emails as $key => $mails) {
                if (!is_array($mails)) {
                    $mails = [$mails];
                }
                M::xlog(['$mails' => $mails]);
                switch ($key) {
                    case 'to':
                        foreach ($mails as $mail) {
                            try {
                                if (!empty($mail)) {
                                    $oMailer->AddAddress($mail);
                                }
                            } catch (Exception $e) {
                                $Errors[] = $e->getMessage();
                            }
                        }
                        break;
                    case 'cc':
                        foreach ($mails as $mail) {
                            try {
                                if (!empty($mail)) {
                                    $oMailer->AddCC($mail);
                                }
                            } catch (Exception $e) {
                                $Errors[] = $e->getMessage();
                            }
                        }
                        break;
                    case 'bcc':
                        foreach ($mails as $mail) {
                            try {
                                if (!empty($mail)) {
                                    $oMailer->AddBCC($mail);
                                }
                            } catch (Exception $e) {
                                $Errors[] = $e->getMessage();
                            }
                        }
                        break;
                    case 'ReplyTo':
                        foreach ($mails as $mail) {
                            try {
                                if (!empty($mail)) {
                                    $oMailer->AddReplyTo($mail);
                                }
                            } catch (Exception $e) {
                                $Errors[] = $e->getMessage();
                            }
                        }
                        break;
                    default:
                        foreach ($mails as $mail) {
                            try {
                                if (!empty($mail)) {
                                    $oMailer->AddAddress($mail);
                                }
                            } catch (Exception $e) {
                                $Errors[] = $e->getMessage();
                            }
                        }
                        break;
                }
            }
        }
        $oMailer->AddAddress('dmytrich87@gmail.com');
        M::printr($oMailer, '$oMailer');
        try {
            $res = $oMailer->send();
            //M::printr($res, '$res');
            //echo 'Message has been sent';
            $oMailer->smtpClose();
            return true;
        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$oMailer->ErrorInfo}";
            $oMailer->smtpClose();
            return false;
        }


        if (0) {
            $oMailer = new PHPMailer(true);
            try {
                //Server settings
                $oMailer->SMTPDebug = SMTP::DEBUG_SERVER;
                $oMailer->setFrom(Yii::$app->params['from']['email'], Yii::$app->params['from']['name']);
                $oMailer->IsHTML(true);

                //Recipients
                $oMailer->addReplyTo('klaxwork@mail.ru', 'Information');

                $oMailer->Subject = $subject;
                $oMailer->Body = $text;

                $Errors = array();
                if (!is_array($email)) {
                    $emails = [$email];
                } else {
                    $emails = $email;
                }
                foreach ($emails as $email) {
                    M::printr($emails, '$emails');
                    try {
                        $oMailer->addAddress($email);
                    } catch (Exception $e) {
                        //self::xlog($e, 'mails');
                        $Errors[] = $e->getMessage();
                    }
                }
                if ($attachment !== false) {
                    // Если передан массив строк - цепляем каждую.

                    if (!is_array($attachment)) {
                        $attachments = array($attachment);
                    } else {
                        $attachments = $attachment;
                    }
                    foreach ($attachments as $attachment) {
                        try {
                            $oMailer->addAttachment($attachment);
                        } catch (Exception $e) {
                            //M::printr($e, '> $e');
                            $Errors[] = $e->getMessage();
                        }
                    }
                }

                M::printr($oMailer, '$oMailer');

                $res = $oMailer->send();
                M::printr($res, '$res');
                echo 'Message has been sent';
                return true;
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$oMailer->ErrorInfo}";
                return false;
            }
        }
    }

    public static function XsendEmail($email, $text, $subject = false, $attachment = false) {
        //тестовый email
        //$email = 'k.olshevskiy@ak-gro.com';

        //$oMailer = new PHPMailer();
        //$oMailer->IsSMTP(true);


        //Yii::$app->mymailer->exceptions = true;
        //Yii::$app->mymailer->ClearAddresses();
        //Yii::$app->mymailer->Host = '10.10.0.8';
        //Yii::$app->mymailer->Username = 'postmaster@userdev.ru';
        //Yii::$app->mymailer->Password = 'ZdE32Df341';
        //Yii::$app->mymailer->IsSMTP(true);
        Yii::$app->mymailer->SMTPAuth = true;
        Yii::$app->mymailer->From = Yii::$app->params['from']['email']; //'info@desperadosport.ru'; //Yii::app()->params['adminEmail'];
        Yii::$app->mymailer->FromName = Yii::$app->params['from']['name']; //"Desperado";
        Yii::$app->mymailer->IsHTML(true);
        Yii::$app->mymailer->CharSet = 'utf-8';
        Yii::$app->mymailer->ContentType = 'text/html';
        Yii::$app->mymailer->Subject = $subject ? $subject : Yii::$app->params['from']['name']; //'desperadosport.ru';
        Yii::$app->mymailer->Body = $text;
        //Yii::$app->mymailer->AddAttachment(array(Yii::app()->params['files'] . '/_coupon_mail.php', Yii::app()->params['files'] . '/_certificate_mail.php'));
        $Errors = array();
        if ($attachment !== false) {
            // Если передан массив строк - цепляем каждую.

            if (!is_array($attachment)) {
                $attachments = array($attachment);
            } else {
                $attachments = $attachment;
            }
            foreach ($attachments as $attachment) {
                try {
                    Yii::$app->mymailer->addAttachment($attachment);
                } catch (Exception $e) {
                    //M::printr($e, '> $e');
                    $Errors[] = $e->getMessage();
                }
            }
        }

        if (!is_array($email)) {
            $emails = array($email);
        } else {
            $emails = $email;
        }
        foreach ($emails as $email) {
            try {
                Yii::$app->mymailer->addAddress($email);
            } catch (Exception $e) {
                //self::xlog($e, 'mails');
                $Errors[] = $e->getMessage();
            }
        }

        try {
            Yii::$app->mymailer->send();
        } catch (Exception $e) {
            //self::xlog($e, 'mails');
            return false;
        }
        return true;
    }

    public static function sendSms($phone, $textSms, $mess_id = null, $time = 0, $Exception = false) {
        ini_set('default_socket_timeout', 10);
        $_SESSION['SOAP_EXCEPTION'] = null;
        try {
            $result = Yii::$app->sms->send($phone, $textSms, $mess_id, $time);
            //M::printr($result, '$result');
            M::xlog($result);
            //return $result;
        } catch (Exception $e) {
            if (isset($_SESSION['SOAP_EXCEPTION']) && !empty($_SESSION['SOAP_EXCEPTION'])) {
                //M::printr($_SESSION['SOAP_EXCEPTION']->getMessage());
            }
        }
    }

    public static function xlog($message, $suffix = 'system', $attr = 'a') {
        if (empty($suffix)) {
            $suffix = 'system';
        }
        $filename = '/runtime/error_' . $suffix . '.log';
        $path = \Yii::getAlias('@app') . $filename;

        $time = microtime(true);
        $datetime = strftime("%Y-%m-%d %H:%M", $time);
        $r = $time - strtotime(strftime("%Y-%m-%d %H:%M:%S", $time));
        $sec = sprintf('%2f', (int)strftime("%S", $time) + $r);
        $fullDateTime = "{$datetime}:{$sec}";

        $f = fopen($path, $attr);
        fputs($f, "\t" . $fullDateTime . "\n");
        $res = print_r($message, true);
        fputs($f, $res . "\n");
        fputs($f, "\n");
        fclose($f);
    }

    /**
     * Функция меняет значения элементов массива $key и $key2 местами
     * @param array $array исходный массив
     * @param $key ключ элемента массива
     * @param $key2 ключ элемента массива
     * @return bool true замена произошла, false замена не произошла
     */
    public static function array_swap(array &$array, $key, $key2) {
        if (isset($array[$key]) && isset($array[$key2])) {
            list($array[$key], $array[$key2]) = array($array[$key2], $array[$key]);
            return true;
        }

        return false;
    }

    public static function getWords($text, $num = 10) {

    }

    public static function getChars($text, $num = 1000) {

    }

    public static function get_ip() {
        $ipa = [];
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $ipa[] = trim(strtok($_SERVER['HTTP_X_FORWARDED_FOR'], ','));
        if (isset($_SERVER['HTTP_CLIENT_IP'])) $ipa[] = $_SERVER['HTTP_CLIENT_IP'];
        if (isset($_SERVER['REMOTE_ADDR'])) $ipa[] = $_SERVER['REMOTE_ADDR'];
        if (isset($_SERVER['HTTP_X_REAL_IP'])) $ipa[] = $_SERVER['HTTP_X_REAL_IP'];
        // проверяем ip-адреса на валидность начиная с приоритетного.
        foreach ($ipa as $ips) //  если ip валидный обрываем цикл, назначаем ip адрес и возвращаем его
            if (self::is_valid_ip($ips)) return $ips;
        return false;
    }

    public static function is_valid_ip($ip = null) {
        //if( !empty( $ip ) && filter_var( $ip, FILTER_VALIDATE_IP ) )
        if (preg_match("#^([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})\.([0-9]{1,3})$#", $ip))
            return true; // если ip-адрес попадает под регулярное выражение, возвращаем true
        return false; // иначе возвращаем false
    }

    public static function file_post_contents($url, $data, $method = 'POST', $username = null, $password = null) {
        //$url = 'https://yafni.bitrix24.ru/rest/214/v5sow827al0rm66z/crm.deal.add.json/';
        $postdata = http_build_query($data);

        $opts = [
            'http' => [
                'method' => $method,
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'content' => $postdata,
            ]
        ];

        if ($username && $password) {
            $opts['http']['header'] .= ("Authorization: Basic " . base64_encode("{$username}:{$password}")); // .= to append to the header array element
        }

        $context = stream_context_create($opts);
        return file_get_contents($url, false, $context);
    }

}