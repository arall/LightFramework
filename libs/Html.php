<?php

/**
 * HTML helper Class
 */
class Html
{
    /**
     * Form button
     *
     * @param string $class
     * @param string $spanClass
     * @param string $display
     * @param array  $attributes
     *
     * @return string
     */
    public static function formButton($class = null, $spanClass = null, $display = null, $attributes = array())
    {
        //Link
        $html = "<button";

        //Default Bootstrap Class
        $attributes["class"] .= $class." btn ladda-button formButton";
        //Default Ladda
        $attributes["data-style"] = "slide-left";

        //Attributes
        $html .= self::buildAttributes($attributes);

        //Link
        $html .= ">";

        //Span
        $html .= "<span class='glyphicon glyphicon-".Helper::sanitize($spanClass)."'></span>";

        if (isset($display)) {
            $html .= Helper::sanitize($display);
        }

        //Link
        $html .= "</button>";

        return $html;
    }

    /**
     * Form Link
     *
     * @param string $class
     * @param string $spanClass
     * @param string $href
     * @param string $display
     * @param array  $attributes
     * @param string $confirmation
     *
     * @return string
     */
    public static function formLink($class = null, $spanClass = null, $href = null, $display = null, $attributes = array(), $confirmation = null)
    {
        //Href
        $attributes["data-link"] = $href;
        //Confirm
        if (isset($confirmation)) {
            $attributes["data-confirmation"] = Helper::sanitize($confirmation);
        }
        //Form Button
        return self::formButton($class, $spanClass, $display, $attributes);
    }

    /**
     * Select Element
     *
     * @param string $name
     * @param array  $list
     * @param string $selected
     * @param array  $attributes
     * @param array  $firstOption
     * @param array  $classOptions
     *
     * @return string
     */
    public static function select($name, $list = array(), $selected = null, $attributes = array(), $firstOption = array(), $classOptions = array())
    {
        //Object
        if (is_object($list[0])) {
            $list = self::objectsToArray($list, $classOptions['id'], $classOptions['display']);
        }

        //Select
        $html = "<select";

        //Default Bootstrap Class
        $attributes["class"] .= " form-control";

        //Name
        if ( ! isset($attributes['name'])) $attributes['name'] = $name;

        //Attributes
        $html .= self::buildAttributes($attributes);

        //Select
        $html .= ">";

        //First Option
        if (!empty($firstOption)) {
            $html .= self::selectAddOption($firstOption["id"], $firstOption["display"]);
        }

        //Options
        $html .= self::selectAddOptions($list, $selected);

        //Select
        $html .= "</select>";

        return $html;
    }

    /**
     * Select: Add Options
     *
     * @param array  $list
     * @param string $selectedValue
     *
     * @return string
     */
    protected static function selectAddOptions($list, $selectedValue = null)
    {
        $html = "";
        foreach ($list as $value => $display) {
            //Translation?
            $translated = Language::translate($display);
            if ($display!=$translated) {
                $display = $translated;
            }
            $html .= self::selectAddOption($value, $display, ($selectedValue == $value && $selectedValue!=null || @in_array($value, $selectedValue)));
        }

        return $html;
    }

    /**
     * Select: Add Option
     *
     * @param string $value
     * @param string $display
     * @param bool   $selected
     *
     * @return string
     */
    protected static function selectAddOption($value, $display, $selected = null)
    {
        //Translation?
        $translated = Language::translate($display);
        if ($display!=$translated) {
            $display = $translated;
        }
        //Selected?
        if ($selected) {
            $selected = "selected";
        }

        return "<option value='".Helper::sanitize($value)."' ".$selected.">".Helper::sanitize($display)."</option>\n";
    }

    /**
     * Object array to array
     *
     * @param array  $objects
     * @param string $id      Key var
     * @param string $display Display var
     *
     * @return string
     */
    protected static function objectsToArray($objects, $id = null, $display = null)
    {
        //Default Id
        if (!$id) $id = "id";
        if (!$display) $display = "name";
        //New array list
        $newList = array();
        foreach ($objects as $object) {
            $newList[(string) $object->$id] = $object->$display;
        }

        return $newList;
    }

    /**
     * Search input
     *
     * @return string
     */
    public static function search()
    {
        return '<div class="input-group">
                    <input type="text" class="form-control" name="search" value="'.Helper::sanitize($_REQUEST["search"]).'">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">'.Language::translate("GENERAL_SEARCH").'</button>
                    </span>
                </div>';
    }

    /**
     * Make a sortable link for a table in a form
     *
     * @param string $sortableField Database Field
     * @param string $text          Text
     *
     * @return string HTML Link
     */
    public function sortableLink($sortableField = "", $text = "")
    {
        $orderDir = "ASC";
        if ($_REQUEST['order']==$sortableField) {
             $cssClass = "sort-by-attributes-alt";
            if ($_REQUEST['orderDir']=="ASC") {
                $orderDir = "DESC";
                $cssClass = "sort-by-attributes";
            }
        }

        return
            "<a href='#' class='sortable' data-order='".Helper::sanitize($sortableField)."' data-orderDir='".Helper::sanitize($orderDir)."'>
                ".Helper::sanitize($text)."
                <span class='glyphicon glyphicon-".Helper::sanitize($cssClass)."'></span>
            </a>";
    }

    /**
     * Make a sort inputs.
     *
     * @return string HTML form inputs
     */
    public function sortInputs()
    {
        return "<input type='hidden' name='order' value='".Helper::sanitize($_REQUEST["order"])."'>
                <input type='hidden' name='orderDir' value='".Helper::sanitize($_REQUEST["orderDir"])."'>";
    }

    /**
     * Make a pagination form inputs.
     *
     * @return string HTML inputs
     */
    public function paginationInputs()
    {
        return "<input type='hidden' name='limit' value='".Helper::sanitize($_REQUEST["limit"])."'>
                <input type='hidden' name='limitStart' value='".Helper::sanitize($_REQUEST["limitStart"])."'>";
    }

    /**
     * Attribute builder
     *
     * @param array $options
     *
     * @return string
     */
    protected static function buildAttributes($options = array())
    {
        $html = "";
        //Atributes
        foreach ((array) $options as $key => $value) {
            $html .= " ".$key."='".Helper::sanitize($value)."'";
        }

        return $html;
    }
}
