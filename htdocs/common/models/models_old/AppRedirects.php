<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArAppRedirects;

/**
 * This is the model class for table "app_redirects".
 *
 * @property int $id
 * @property string $from_url
 * @property string $to_url
 * @property string $dt_created
 * @property string $dt_updated
 * @property bool $is_deprecated
 * @property bool $is_deleted
 */
class AppRedirects extends RArAppRedirects
{

}
