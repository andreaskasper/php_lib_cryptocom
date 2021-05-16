<?php
namespace cryptocom;

class Currency {

    private $_id = null;

    public function __construct($v) {
        $this->_id = $v;
    }

    public function __get($name) {
        switch (strtolower($name)) {
            case "id": return $this->_id;
            case "string": return $this->__string();
            case "symbol": return $this->symbol();
        }
    }

    public function symbol() :string {
        switch ($this->_currency) {
            case "BCH": return "Ƀ";
            case "BTC": return "₿";
            case "DOGE": return "Ð";
            case "ETH": return "Ξ";
            case "USDT": return "₮";
            case "XRP": return "✕";
            default: return $this->_currency;
        }
    }

    public function __string() {
        return $this->_id;
    }
}
