<?php

namespace App\Helpers;


class FormHelper
{
    /**
     * Get value input.
     *
     * @param $model
     * @param $column
     * @param $default
     * @return mixed|string
     */
    public static function getValInput($model, $column, $default = null)
    {
        $oldColumn = old($column);
        if (!is_null($oldColumn) && !is_array($oldColumn)) {
            return $oldColumn;
        }

        if (is_object($model)) {
            if (is_null($model->{$column}) && !is_null($default)) {
                return $default;
            }
            return $model->{$column};
        }

        if (!is_null($default)) {
            return $default;
        }

        return '';
    }

    /**
     * Get value select box.
     *
     * @param $model
     * @param $attribute
     * @param $valueCheck
     * @param $default
     * @return string|void
     */
    public static function getValSelect($model, $attribute, $valueCheck, $default = null)
    {
        $oldColumn = old($attribute);

        if (!is_null($oldColumn) && !is_array($oldColumn) && $oldColumn == $valueCheck) {
            return 'selected';
        }

        if (is_object($model) && !is_null($model->{$attribute}) && $model->{$attribute} == $valueCheck) {

            return 'selected';
        }

        if (!is_object($model) && is_null($oldColumn) && !is_null($default) && $default == $valueCheck) {

            return 'selected';
        }
    }

    /**
     * Get value checkbox.
     *
     * @param $model
     * @param $attribute
     * @param $valueCheck
     * @param $default
     * @param $multipleForm
     * @return string
     */
    public static function getValCheckBox($model, $attribute, $valueCheck, $default = null, $multipleForm = null)
    {
        $oldColumn = old($attribute);
        if (!is_null($oldColumn) && !is_array($oldColumn) && $oldColumn == $valueCheck) {
            return 'checked';
        }

        if (is_array($oldColumn) && key_exists($multipleForm, $oldColumn)) {

            if (is_array($oldColumn[$multipleForm])) {
                foreach ($oldColumn[$multipleForm] as $value) {
                    if ($value == $valueCheck) {
                        return 'checked';
                    }
                }
            }
            if ($oldColumn[$multipleForm] == $valueCheck) {
                return 'checked';
            }
        }

        if (is_array($oldColumn)) {

            foreach ($oldColumn as $value) {
                if ($value == $valueCheck) {
                    return 'checked';
                }
            }
        }

        if (is_object($model)) {
            if (!is_null($model->{$attribute}) && $model->{$attribute} == $valueCheck) {
                return 'checked';
            }

        }

        if (!is_null($default) && $default == $valueCheck) {
            return 'checked';
        }

        return '';
    }
}
