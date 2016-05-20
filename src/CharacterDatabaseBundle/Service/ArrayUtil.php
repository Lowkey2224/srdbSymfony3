<?php
/**
 * @author Marcus Jenz
 */

namespace CharacterDatabaseBundle\Service;


class ArrayUtil
{
    public static function get(array $root, $compositeKey, $default = null){
        $keys = explode('.', $compositeKey);
        while(count($keys) > 1) {
            $key = array_shift($keys);
            if(!isset($root[$key])) {
                return $default;
            }
            $root = $root[$key];
        }
        $key = reset($keys);
        return isset($root[$key])?$root[$key]:$default;
    }

    public static function set(&$root, $compositeKey, $value) {
        $keys = explode('.', $compositeKey);
        while(count($keys) > 1) {
            $key = array_shift($keys);
            if(!isset($root[$key])) {
                $root[$key] = array();
            }
            $root = &$root[$key];
        }

        $key = reset($keys);
        $root[$key] = $value;
    }
}