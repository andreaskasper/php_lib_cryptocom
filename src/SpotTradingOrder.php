<?php

namespace cryptocom;

class SpotTradingOrder {

    private $_id = null;
    private $cacheurdata = null;
    private $cachedata0 = null;

    public function __construct($v) {
        //echo("Test:".$v.PHP_EOL);
        if (is_string($v) OR is_numeric($v)) {
            $this->_id = $v."";
        } elseif (is_array($v) AND !empty($v)) {
            $this->cacheurdata = $v;
            $this->_id = $v["order_id"];
        }
    }

    public function __get($name) {
        switch ($name) {
            case "id": return $this->_id;
            case "data": $this->load0(); return $this->cachedata0;
            case "urdata": return $this->cacheurdata;
            case "exist":
            case "exists": $a = $this->load0(); return !empty($a["result"]["order_info"]["status"]);
            case "status": return $this->cacheurdata["status"] ?? $this->load0()["result"]["order_info"]["status"] ?? null;
            case "side": return $this->cacheurdata["side"] ?? $this->load0()["result"]["order_info"]["side"] ?? null;
            case "instrument_string": return $this->cacheurdata["instrument_name"] ?? $this->load0()["result"]["order_info"]["instrument_name"] ?? null;
            case "instrument": if (!is_null($this->instrument_string)) return new Instrument($this->instrument_string); else return null;
            case "type": return $this->cacheurdata["type"] ?? $this->load0()["result"]["order_info"]["type"] ?? null;
            case "price": return new Price($this->cacheurdata["price"] ?? $this->load0()["result"]["order_info"]["price"] ?? null, $this->instrument->quote->id);
            case "quantity": return new Quantity($this->cacheurdata["quantity"] ?? $this->load0()["result"]["order_info"]["quantity"] ?? null, $this->instrument->base->id);
            case "created": new \DateTime("@".($this->cacheurdata["create_time"] ?? $this->load0()["result"]["order_info"]["create_time"] ?? null));
            case "updated": new \DateTime("@".($this->cacheurdata["update_time"] ?? $this->load0()["result"]["order_info"]["update_time"] ?? null));
        }
        return null;
    }

    public function refresh() {
        $w = array();
        $w["order_id"] = $this->_id;
        $this->cachedata0 = core::request("private/get-order-detail", $w, true);
        return $this->cachedata0;
    }

    private function load0() {
        if (is_null($this->cachedata0)) {
            return $this->refresh();
        }
        return $this->cachedata0;
    }

}
