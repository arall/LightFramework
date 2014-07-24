<?php

/**
 * Toolbar Class
 */
class Toolbar
{
    /**
     * Current title
     * @var array
     */
    private static $title = NULL;

    /**
     * Current buttons
     * @var array
     */
    private static $buttons = NULL;

    public static function addTitle($title, $class=null, $subtitle=null)
    {
        self::$title = array(
            "title" => $title,
            "class" => $class,
            "subtitle" => $subtitle,
        );
    }

    public static function addButton($params = array())
    {
        self::$buttons[] = $params;
    }

    public static function render()
    {
        $title = self::$title;
        $buttons = self::$buttons;
        ?>
        <div class="toolbar row">
            <div class="title">
                <h1>
                    <span class="glyphicon <?=$title["class"]?>"></span>
                    <?=Helper::sanitize($title["title"]);?>
                    <small>
                       <?=Helper::sanitize($title["subtitle"]);?>
                    </small>
                </h1>
            </div>
            <div class="tools">
                <?php if (count($buttons)) { ?>
                    <?php foreach ($buttons as $button) { ?>
                        <?=HTML::formButton("btn-".$button['class'], $button['spanClass'], $button['title'], array(
                                "id" => $button['id'],
                                "data-app" => $button['app'],
                                "data-action" => $button['action'],
                                "data-requireIds" => $button['requireIds'],
                                "data-confirmation" => $button['confirmation'],
                                "data-ajax" => $button['ajax'],
                                "data-noAjax" => $button['noAjax'],
                                "data-link" => $button['link'],
                                "data-data-modal" => $button['modal'],
                            )
                        );?>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <?php
    }
}
