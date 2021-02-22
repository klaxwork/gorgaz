<?php

namespace frontend\components\widgets\BreadcrumbsWidget;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class BreadcrumbsWidget extends Widget

{
    public $is_hide_last = false;
    /**
     * @var string the tag name for the breadcrumbs container tag. Defaults to 'div'.
     */
    public $tagName = 'ul';
    /**
     * @var array the HTML attributes for the breadcrumbs container tag.
     */
    public $htmlOptions = array('class' => 'list');
    /**
     * @var boolean whether to HTML encode the link labels. Defaults to true.
     */
    public $encodeLabel = false;
    /**
     * @var array list of hyperlinks to appear in the breadcrumbs. If this property is empty,
     * the widget will not render anything. Each key-value pair in the array
     * will be used to generate a hyperlink by calling CHtml::link(key, value). For this reason, the key
     * refers to the label of the link while the value can be a string or an array (used to
     * create a URL). For more details, please refer to {@link CHtml::link}.
     * If an element's key is an integer, it means the element will be rendered as a label only (meaning the current page).
     *
     * The following example will generate breadcrumbs as "Home > Sample post > Edit", where "Home" points to the homepage,
     * "Sample post" points to the "index.php?r=post/view&id=12" page, and "Edit" is a label. Note that the "Home" link
     * is specified via {@link homeLink} separately.
     *
     * <pre>
     * array(
     *     'Sample post'=>array('post/view', 'id'=>12),
     *     'Edit',
     * )
     * </pre>
     */
    public $links = array();

    /**
     * @var string the first hyperlink in the breadcrumbs (called home link).
     * If this property is not set, it defaults to a link pointing to {@link CWebApplication::homeUrl} with label 'Home'.
     * If this property is false, the home link will not be rendered.
     */
    public $homeLink = '<li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" itemref="{ref}"><a href="/" itemprop="url" title="{label}"><span itemprop="title" class="blue">{label}</span></a></li>';

    /**
     * @var string String, specifies how each active item is rendered. Defaults to
     * "<a href="{url}">{label}</a>", where "{label}" will be replaced by the corresponding item
     * label while "{url}" will be replaced by the URL of the item.
     * @since 1.1.11
     */
    public $activeLinkTemplate = '<li itemprop="child" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" id="{parent}" itemref="{ref}"><a href="{url}" itemprop="url"><span itemprop="title" class="blue">{label}</span></a></li>';

    /**
     * @var string String, specifies how each inactive item is rendered. Defaults to
     * "<span>{label}</span>", where "{label}" will be replaced by the corresponding item label.
     * Note that inactive template does not have "{url}" parameter.
     * @since 1.1.11
     */
    public $inactiveLinkTemplate = '<li style="{display}" itemprop="child" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" id="{parent}"><span itemprop="title">{label}</span><a itemprop="url" href="{url}" style="display: none;" rel="nofollow" title="{label}">{label}</a></li>';

    /**
     * @var string the separator between links in the breadcrumbs. Defaults to ' &raquo; '.
     */
    public $separator = null; //' &raquo; ';

    public $parent = 'parent';
    public $child = 'child';


    /**
     * Renders the content of the portlet.
     */
    public function run()
    {
        if (empty($this->links))
            return;

        $definedLinks = $this->links;

        $classes = '';
        foreach ($this->htmlOptions as $class) {
            $classes .= $class;
        }
        print "<{$this->tagName} class='{$classes}'>";
        //echo CHtml::openTag($this->tagName, $this->htmlOptions) . "\n";
        $links = [];
        /*if ($this->homeLink === null) {
            $definedLinks = array_merge(array(Yii::t('zii', 'Home') => Yii::app()->homeUrl), $definedLinks);
        } elseif ($this->homeLink !== false) {
            $links[] = $this->homeLink;
        }*/
        $i = 0;
        $template = $this->activeLinkTemplate;
        $display = '';
        foreach ($definedLinks as $label => $url) {
            switch ($i) {
                case 0:
                    $template = $this->homeLink;
                    break;
                case count($definedLinks) - 1:
                    $template = $this->inactiveLinkTemplate;
                    if ($this->is_hide_last) {
                        $display = 'display: none;';
                        //$template = "<span style='display: none'>{$template}</span>";
                    }
                    break;
                default:
                    $template = $this->activeLinkTemplate;
                    break;
            }
            $links[] = strtr(
                $template, [
                    '{display}' => $display,
                    '{url}' => $url,
                    '{label}' => str_replace('&quot;', '&#8243;', $this->encodeLabel ? yii\helpers\Json::encode($label) : $label),
                    '{parent}' => 'breadcrumb-' . $i,
                    '{ref}' => 'breadcrumb-' . ($i + 1)
                ]
            );
            $i++;
        }
        //M::printr($url, '$url');
        //\common\components\M::printr($links, '$links');
        //M::printr($links, '$links');
        echo implode($this->separator, $links);
        print "</{$this->tagName}>";
        //echo CHtml::closeTag($this->tagName);
    }
}