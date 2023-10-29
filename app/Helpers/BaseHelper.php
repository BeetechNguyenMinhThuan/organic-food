<?php

namespace App\Helpers;


use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class BaseHelper
{
    /**
     * Escape string in query like
     *
     * @param String $string
     * @return string
     */
    public static function escapeLike($string): string
    {
        $arySearch = array('\\', '%', '_');
        $aryReplace = array('\\\\', '\%', '\_');
        return str_replace($arySearch, $aryReplace, $string);
    }

    public static function formatDate(string $date, string $format = null): string
    {
        if (empty($format)) {
            $format = config('general.date_format.date');
        }

        if (empty($date)) {
            return '-';
        }

        return Carbon::parse($date)->format($format);
    }

    public static function recursiveItems(array $items, string $name, array $argDefault = [], int $parentId = 0)
    {
        # Get first item parent = 0
        $argTemp = [];
        foreach ($items as $key => $item) {
            if (isset($item->parent_id) && $item->parent_id == $parentId) {
                $argTemp[] = $item;
                unset($items[$key]);
            }
        }
        # Loop arg step 1, The stopping condition of the recursion is until the menu is gone
        $html = '';
        $html .= "<ul>";
            foreach ($argTemp as $item) {
                $html .= '<li value="'.$item->id.'">';
                    if (in_array($item->id, $argDefault)) {
                        $html .= '<label class="checkbox blue"><input type="checkbox" value="'.$item->id.'" name="'.$name.'[]" checked>&nbsp;&nbsp;'.$item->name.'</label>';
                    } else {
                        $html .= '<label class="checkbox blue"><input type="checkbox" value="'.$item->id.'" name="'.$name.'[]" >&nbsp;&nbsp;'.$item->name.'</label>';
                    }
                    # Pass in the list of unrepeatable menus and the parent id of the current menu
                    self::recursiveItems($items, $name, $argDefault, $item->id);
                $html .= '</li>';
            }
        $html .= "</ul>";
        return $html;
    }

    public static function generalMultiSelect(array $items, string $name, array $argDefault = [])
    {
        # Loop arg step 1, The stopping condition of the recursion is until the menu is gone
        $html = '';
        $html .= "<ul>";
        foreach ($items as $item) {
            $html .= '<li value="'.$item->id.'">';
            if (in_array($item->id, $argDefault)) {
                $html .= '<label class="checkbox blue"><input type="checkbox" value="'.$item->id.'" name="'.$name.'[]" checked>&nbsp;&nbsp;'.$item->name.'</label>';
            } else {
                $html .= '<label class="checkbox blue"><input type="checkbox" value="'.$item->id.'" name="'.$name.'[]" >&nbsp;&nbsp;'.$item->name.'</label>';
            }
            $html .= '</li>';
        }
        $html .= "</ul>";
        return $html;
    }

    public static function generalRadio(array $items, string $name, array $argDefault = [])
    {
        # Loop arg step 1, The stopping condition of the recursion is until the menu is gone
        $html = '';
        $html .= "<ul>";
        foreach ($items as $item) {
            $html .= '<li value="'.$item->id.'">';
            if (in_array($item->id, $argDefault)) {
                $html .= '<label class="radio blue"><input type="radio" value="'.$item->id.'" name="'.$name.'" checked>&nbsp;&nbsp;'.$item->name.'</label>';
            } else {
                $html .= '<label class="radio blue"><input type="radio" value="'.$item->id.'" name="'.$name.'" >&nbsp;&nbsp;'.$item->name.'</label>';
            }
            $html .= '</li>';
        }
        $html .= "</ul>";
        return $html;
    }

    public static function generalDropdown(array $items, string $name, array $argDefault = [])
    {
        # Loop arg step 1, The stopping condition of the recursion is until the menu is gone
        $html = '';
        $html .= "<select name='".$name."' required style='height:40px;'>";
        $html .= '<option value="0"> Chọn author </option>';
        foreach ($items as $item) {

            if (in_array($item->id, $argDefault)) {
                $html .= '<option value="'.$item->id.'" selected>'.$item->name.'</option>';
            } else {
                $html .= '<option value="'.$item->id.'">'. $item->name. '</option>';
            }
        }
        $html .= "</select>";
        return $html;
    }

    public static function getLocales() {
        $locales = ['vi', 'en', 'ja'];
        $locale = App::getLocale();
        if (($key = array_search($locale, $locales)) !== false) {
            unset($locales[$key]);
            array_unshift($locales, $locale);
        }
        return $locales;
    }

    public static function splitString($string, $length, $operator): string
    {
        if (mb_strlen($string) > $length) {
            $string = substr($string, 0, $length) . $operator;
        }
        return $string;
    }
}
