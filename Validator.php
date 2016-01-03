<?php

class Validator {

    public static $message = array();

    public static function Validate($validations_arr, $input_arr) {
        self::$message = array();

        $is_valid = TRUE;
        if (self::has_string_keys($input_arr)) {
            foreach ($validations_arr as $validationKey => $validationValue) {
                $validationValue = strtolower($validationValue);
                if (strpos($validationKey, '.') === FALSE) {
                    $is_valid = self::premitive_validator($validationKey, $validationValue, $input_arr);
                    if (!$is_valid) {
                        break;
                    }
                } else {
                    if (strpos($validationKey, '.') !== FALSE) {
                        $arrayKeys = explode('.', $validationKey);
                        $sub_valid = array();
                        for ($i = 1; $i < count($arrayKeys); $i++) {
                            $subKey = $arrayKeys[1];
                            if ($subKey == $arrayKeys[count($arrayKeys) - 1]) {
                                $sub_valid[$subKey] = $validationValue;
                            } else {
                                for ($j = $i + 1; $j < count($arrayKeys) - 1; $j++) {
                                    $subKey.='.' . $arrayKeys[$j];
                                }
                                $sub_valid[$subKey] = "array";
                            }
                            $is_valid = self::Validate($sub_valid, $input_arr[$arrayKeys[$i - 1]]);
                            if (!$is_valid) {
                                break;
                            }
                        }
                    }
                }
            }
        } else {
            foreach ($validations_arr as $validationKey => $validationValue) {
                foreach ($input_arr as $input_without_numbers) {
                    $is_valid = self::premitive_validator($validationKey, $validationValue, $input_without_numbers);
                    if (!$is_valid) {
                        break;
                        break;
                    }
                }
            }
        }
        return $is_valid;
    }

    private static function premitive_validator($validationKey, $validationValue, $input_arr) {
        if (strpos($validationValue, 'required') !== false) {
            if (!isset($input_arr[$validationKey])) {
                self::$message[$validationKey] = " is a required field";
                return FALSE;
            }
        }
        if (strpos($validationValue, 'string') !== false) {
            if (isset($input_arr[$validationKey])) {
                if (!is_string($input_arr[$validationKey])) {
                    self::$message[$validationKey] = " is a string field";
                    return FALSE;
                }
            }
        }
        if (strpos($validationValue, 'numeric') !== false) {
            if (isset($input_arr[$validationKey])) {
                if (!is_numeric($input_arr[$validationKey])) {
                    self::$message[$validationKey] = " is a numeric field";
                    return FALSE;
                }
            }
        }
        if (strpos($validationValue, 'boolean') !== false) {
            if (isset($input_arr[$validationKey])) {
                if (((int) $input_arr[$validationKey] != 0) && ((int) $input_arr[$validationKey] != 1)) {
                    if (!is_bool($input_arr[$validationKey])) {
                        self::$message[$validationKey] = " is a boolean field";
                        return FALSE;
                    }
                }
            }
        }
        if (strpos($validationValue, 'array') !== false) {
            if (isset($input_arr[$validationKey])) {
                if (!is_array($input_arr[$validationKey])) {
                    self::$message[$validationKey] = " is a array";
                    return FALSE;
                }
                if (count($input_arr[$validationKey]) < 1) {
                    self::$message[$validationKey] = " is a an empty array field";
                    return FALSE;
                }
            }
        }
        return TRUE;
    }

    public static function ValidationMessage() {
        self::$message["message"] = "Please check your input";
        return self::$message;
    }

    private static function has_string_keys(array $array) {
        return count(array_filter(array_keys($array), 'is_string')) > 0;
    }

}
