<?php
namespace cryptocom;

class Common {

    public static function book(Instrument $instrument, int $depth = null) : Array {
        $out = array();
        $w = array();
        $w["instrument_name"] = $instrument->id;
        if (!empty($depth)) $w["depth"] = $depth;
        $data = core::request("public/get-book", $w);
        //print_r($data); exit;
        foreach ($data["result"]["data"][0]["bids"] as $row) $out["bids"][] = array("price" => new Price($row[0], $instrument->base->id), "quantity" => new Quantity($row[1], $instrument->quote->id), "count" => $row[2]);
        foreach ($data["result"]["data"][0]["asks"] as $row) $out["asks"][] = array("price" => new Price($row[0], $instrument->base->id), "quantity" => new Quantity($row[1], $instrument->quote->id), "count" => $row[2]);
        $out["instrument"] = $instrument;
        $out["timestamp"] = new \DateTime("@".($data["result"]["data"][0]["t"]/1000));
        return $out;
    }

    public static function get_deposit_address(Currency $currency) : Array {
        $out = array();
        $w = array();
        $w["currency"] = $currency->id;
        //print_r($w);
        $data = core::request("private/get-deposit-address", $w, true);
        return $data["result"]["deposit_address_list"] ?? null;
    }

    

}
