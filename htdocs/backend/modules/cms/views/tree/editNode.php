<?php
//$cs = Yii::app()->clientScript;
//$themePath = Yii::app()->theme->baseUrl;
//$cs->registerCssFile($themePath . '/vendor/plugins/summernote/summernote.css');
//$cs->registerScriptFile($themePath . '/vendor/plugins/summernote/summernote.min.js', CClientScript::POS_END);

print $this->context->renderPartial(
    '_form',
    [
        'id' => $id,
        'formName' => $formName,
        'oNode' => $oNode,
        'oImages' => $oImages,
        'oFields' => $oFields,
        //'descendants' => $descendants,
    ]
);
?>