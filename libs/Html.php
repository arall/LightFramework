<?php

/**
 * HTML helper Class
 */
class HTML
{

    public static function formButton($class = null, $spanClass = null, $display = null, $options = array())
    {
        //Link
        $html = "<button";

        //Default Bootstrap Class
        $options["class"] .= $class." btn ladda-button formButton";
        //Default Ladda
        $options["data-style"] = "slide-left";

        //Attributes
        $html .= self::buildAttributes($options);

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

    public static function formLink($class = null, $spanClass = null, $href = null, $display = null, $options = array(), $confirmation = null)
    {
        //Href
        $options["data-link"] = $href;
        //Confirm
        if (isset($confirmation)) {
            $options["data-confirmation"] = Helper::sanitize($confirmation);
        }
        //Form Button
        return self::formButton($class, $spanClass, $display, $options);
    }

    public static function select($name, $list = array(), $selected = null, $options = array(), $firstOption = array(), $classOptions = array())
    {
        //Selected value
        $selectedArray = array();
        if (is_array($selected)) {
            if (!empty($selected)) {
                foreach ($selected as $s) {
                    $selectedArray[$s] = "selected";
                }
            }
        } else {
            $selectedArray[$selected] = "selected";
        }

        //Object
        if (is_object($list[0])) {
            //Default Id
            if ( ! isset($classOptions['id'])) $classOptions['id'] = "id";
            if ( ! isset($classOptions['display'])) $classOptions['display'] = "name";
            //New array list
            $newList = array();
            foreach ($list as $object) {
                $display = $object->$classOptions['display'];
                $newList[(string) $object->$classOptions['id']] = $display;
            }
            $list = $newList;
            unset($newList);
        }

        //Select
        $html = "<select";

        //Default Bootstrap Class
        $options["class"] .= " form-control";

        //Name
        if ( ! isset($options['name'])) $options['name'] = $name;

        //Attributes
        $html .= self::buildAttributes($options);

        //Select
        $html .= ">";

        //First Option
        if (!empty($firstOption)) {
            if ( ! isset($firstOption['id'])) $firstOption['id'] = 0;
            if ( ! isset($firstOption['display'])) $firstOption['display'] = "Selecciona una opción";
            $html .= "<option value='".Helper::sanitize($firstOption["id"])."'>".Helper::sanitize($firstOption["display"])."</option>\n";
        }
        //Options
        foreach ($list as $value => $display) {
            //Translation?
            $translated = Language::translate($display);
            if ($display!=$translated) {
                $display = $translated;
            }
            $html .= "<option value='".Helper::sanitize($value)."' ".$selectedArray[$value].">".Helper::sanitize($display)."</option>\n";
        }

        //Select
        $html .= "</select>";

        return $html;
    }

    public static function search()
    {
        return '<div class="input-group">
                    <input type="text" class="form-control" name="search" value="'.Helper::sanitize($_REQUEST["search"]).'">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">Buscar</button>
                    </span>
                </div>';
    }

    /**
     * Make a sortable link for a table in a form
     *
     * @param  string $field Database Field
     * @param  string $text  Text
     * @return string HTML Link
     */
    public function sortableLink($field="", $text="")
    {
        $order = $field;
        $orderDir = "ASC";
        if ($_REQUEST['order']==$field) {
             $cssClass = "sort-by-attributes-alt";
            if ($_REQUEST['orderDir']=="ASC") {
                $orderDir = "DESC";
                $cssClass = "sort-by-attributes";
            }
        }

        return
            "<a href='#' class='sortable' data-order='".Helper::sanitize($order)."' data-orderDir='".Helper::sanitize($orderDir)."'>
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
