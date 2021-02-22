<?php

namespace common\models;

//use common\models\models\I8tags;
use common\models\ar_inherit\I8tags;

class CMSI8Tag
{

    public static function create() {
        $mark = self::timestamp();
        $model = new I8tags();
        $model->i8key = $mark;
        $model->i8tag = self::alphaID($mark);
        if ($model->save()) {
            return $model;
        }
    }


    public static function generate() {
        return self::alphaID(self::timestamp());
    }


    public static function timestamp() {
        return str_replace(['0.', '0 ', ' '], NULL, microtime(false) . mt_rand(10, 99));
    }

    public static function alphaID($in, $to_num = false, $pad_up = false) {
        $out = '';
        $index = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $base = strlen($index);
        if ($to_num) {
            // Digital number  <<--  alphabet letter code
            $len = strlen($in) - 1;
            for ($t = $len; $t >= 0; $t--) {
                $bcp = pow($base, $len - $t);
                $out = $out + strpos($index, substr($in, $t, 1)) * $bcp;
            }
            if (is_numeric($pad_up)) {
                $pad_up--;
                if ($pad_up > 0) {
                    $out -= pow($base, $pad_up);
                }
            }
        } else {
            // Digital number  -->>  alphabet letter code
            if (is_numeric($pad_up)) {
                $pad_up--;
                if ($pad_up > 0) {
                    $in += pow($base, $pad_up);
                }
            }
            for ($t = ($in != 0 ? floor(log($in, $base)) : 0); $t >= 0; $t--) {
                $bcp = pow($base, $t);
                $a = floor($in / $bcp) % $base;
                $out = $out . substr($index, $a, 1);
                $in = $in - ($a * $bcp);
            }
        }
        return $out;
    }


}


