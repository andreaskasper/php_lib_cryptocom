<?php

namespace cryptocom;

class Price {

    private $_amount = null;
    private $_currency = null;

    public function __construct($a1 = null, $a2 = null) {
        if (is_numeric($a1) AND is_string($a2)) {
            $this->_amount = $a1;
            $this->_currency = $a2;
        }
    }

    public function __get($name) {
        switch($name) {
            case "amount": return $this->_amount;
            case "value": return $this->_amount;
            case "string": return $this->_amount.$this->currency->symbol;
            case "currency": return new Currency($this->_currency);
        }
        return null;
    }

    public function __string() {
        return $this->_amount.$this->currency->symbol;
    }

    public function multiply($value) {
        if (is_object($value) AND get_class($value) == "cryptocom\Quantity") return new Price($this->_amount*$value->amount, $this->_currency);
        return new Price($this->_amount*$value, $this->_currency);
    }

}
