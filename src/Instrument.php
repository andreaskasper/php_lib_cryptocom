<?php

/**
 * Instrument is a pair of 2 currencies
 *
 * Instrument is a pair of 2 currencies
 *
 * @category   cryptocoins
 * @package    cryptocom
 * @author     Andreas Kasper <andreas.kasper@goo1.de>
 * @copyright  2021
 * @license    MIT
 * @version    Release: 0.1
 * @link       https://github.com/andreaskasper/php_lib_cryptocom/
 * @see        /examples
 * @since      2021-05-12
 **/

namespace cryptocom;

class Instrument {

    private static $_cache = null;
    private static $_cache2 = array();
    private $_id = null;

    public function __construct($id = null, $id2 = null) {
        if (is_null($id2) AND preg_match("@^[A-Z]+-[A-Z]+$@", $id)) {
            $this->_id = $id;
            return;
        }
        if (!is_null($id) AND !is_null($id2)) {
            $this->_id = $id->id."-".$id2->id;
            return;
        }
    }

    public function __get($name) {
        switch ($name) {
            case "id":
                return $this->_id;
            case "exists":
                self::load0();
                return isset(self::$_cache2[$this->_id]);
            case "base":
                self::load0();
                return new Currency(self::$_cache2[$this->_id]["base_currency"] ?? null);
            case "quote":
                self::load0();
                return new Currency(self::$_cache2[$this->_id]["quote_currency"] ?? null);
            case "price_decimals":
                self::load0();
                return self::$_cache2[$this->_id]["price_decimals"] ?? null;
            case "quantity_decimals":
                self::load0();
                return self::$_cache2[$this->_id]["quantity_decimals"] ?? null;
        }
    }

    public static function list() {
        self::load0();
        $out = array();
        foreach (self::$_cache2 as $k => $v) $out = new Instrument($k);
        return $out;
    }


    private static function load0() {
        if (is_null(self::$_cache)) {
            self::$_cache = core::request("public/get-instruments", array(), false);
            foreach (self::$_cache["result"]["instruments"] as $row) self::$_cache2[$row["instrument_name"]] = $row;
        }
        return self::$_cache;
    }
}
