  
<?php

namespace cryptocom;

class Coins {

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
            case "tousdt":
            case "inusdt":
                if ($this->_currency == "USDT") return $this;
                if ($this->amount == 0) return new Coins(0, "USDT");
                $inst = new Instrument($this->_currency."_USDT");
                $book = Common::book($inst, 1);
                return new Coins((( $book["asks"][0]["price"] + $book["bids"][0]["price"]) / 2) * $this->_amount, "USDT");
        }
        return null;
    }

    public function __string() {
        return $this->_amount.$this->currency->symbol;
    }
  
    public function toUSDT() : Coins {
        if ($this->_currency == "USDT") return $this;
        if ($this->_amount == 0) return new Coins(0, "USDT");
        $inst = new Instrument($this->_currency."_USDT");
        $book = Common::book($inst, 1);
        return new Coins((( $book["asks"][0]["price"] + $book["bids"][0]["price"]) / 2) * $this->_amount, "USDT");
    }

    public function multiply($value) {
        if (is_object($value) AND get_class($value) == "cryptocom\Quantity") return new Price($this->_amount*$value->amount, $this->_currency);
        return new Price($this->_amount*$value, $this->_currency);
    }

}
