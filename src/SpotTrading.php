<?php

namespace cryptocom;

class SpotTrading {

    CONST GOOD_TILL_CANCEL = 1;
    CONST FILL_OR_KILL = 2;
    CONST IMMEDIATE_OR_CANCEL = 3;
    CONST BUY = 5;
    CONST SELL = 6;

    public static function account_summary($currency = null) : Array {
        if (empty($currency)) $res = core::request("private/get-account-summary", array(), true);
        else $res =  core::request("private/get-account-summary", array("currency" => $currency), true);
        //print_r($res);
        $out = array();
        foreach ($res["result"]["accounts"] as $row) {
            $out[$row["currency"]] = array(
                "balance" => new Quantity($row["balance"], $row["currency"]),
                "available" => new Quantity($row["available"], $row["currency"]),
                "order" => new Quantity($row["order"], $row["currency"]),
                "stake" => new Quantity($row["stake"], $row["currency"]),
                "currency" => new Currency($row["currency"])
            );
        }
        return $out;
    }

    public static function cancel_all_orders(Instrument $instrument) {
        $w = array();
        $w["instrument_name"] = $instrument->id;
        return core::request("private/cancel-all-orders", $w, true);
    }

    public static function create_limit_order(Instrument $instrument, $side, mixed $quantity, mixed $price, $timeinforce = null) {
        if (is_null($timeinforce)) $timeinforce = self::GOOD_TILL_CANCEL;
        if (!in_array($side, array(self::BUY, self::SELL))) throw new \Exception("Unknown Side");
        if (!in_array($timeinforce, array(self::GOOD_TILL_CANCEL, self::FILL_OR_KILL, self::IMMEDIATE_OR_CANCEL))) throw new \Exception("Unknown TimeInForce");
        $w = array();
        $w["instrument_name"] = $instrument->id;
        $w["side"] = [5 => "BUY", 6 => "SELL"][$side];
        $w["type"] = "LIMIT";

        if (is_numeric($price)) $w["quantity"] = number_format($quantity, $instrument->quantity_decimals, ".", "");
        else $w["quantity"] = number_format($quantity->amount, $instrument->quantity_decimals, ".", "");

        if (is_numeric($price)) $w["price"] = number_format($price, $instrument->price_decimals, ".", "");
        else $w["price"] = number_format($price->amount, $instrument->price_decimals, ".", "");
        $w["time_in_force"] = [1 => "GOOD_TILL_CANCEL",2 => "FILL_OR_KILL",3 => "IMMEDIATE_OR_CANCEL"][$timeinforce];
        $resp = core::request("private/create-order", $w, true);
        if ($resp["code"] == 30008) throw new \Exception("Minimales Investment für ".$w["instrument_name"]." mit ".$w["quantity"]." unterschritten...");
        if ($resp["code"] != 0) throw new \Exception("Problem mit Order: ".json_encode($resp));
        //print_r($resp);
        return new SpotTradingOrder($resp["result"]["order_id"]."");
    }

    public static function open_orders(Instrument $instrument, int $page = null, int $pagesize = null) {
        $out = array();
        $w = array();
        $w["instrument_name"] = $instrument->id;
        if (!is_null($page)) $w["page"] = $page;
        if (!is_null($pagesize)) $w["page_size"] = $pagesize;
        $resp = core::request("private/get-open-orders", $w, true);
        foreach ($resp["result"]["order_list"] as $row) $out[] = new SpotTradingOrder($row);
        return $out;
    }

    public static function order_history(Instrument $instrument, \DateTime $start_ts = null, \DateTime $end_ts = null, int $page = null, int $pagesize = null) {
        $out = array();
        $w = array();
        $w["instrument_name"] = $instrument->id;
        if (!is_null($page)) $w["page"] = $page;
        if (!is_null($pagesize)) $w["page_size"] = $pagesize;
        $resp = core::request("private/get-order-history", $w, true);
        foreach ($resp["result"]["order_list"] as $row) $out[] = new SpotTradingOrder($row);
        return $out;
    }
}
