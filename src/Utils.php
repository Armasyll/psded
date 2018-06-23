<?php
namespace PSDE;

class Utils {
    public static function sanitizeString($string) {
        return htmlentities($string);
    }
    public static function fresponse($status = 200, $msg = "OK", $timestamp = 0, $response) {
        return array(
            "meta"=>array(
                "status"=>$status,
                "msg"=>$msg,
                "timestamp"=>$timestamp
            ),
            "response"=>$response
        );
    }
    /**
     * Generates RFC 4211 Compliant UUID v4 String
     *
     * @return UUID
     *
     * RFC 4211 Complient UUID v4 string
     * by Andrew Moore, http://php.net/manual/en/function.uniqid.php#94959
     */
    public static function genUUIDv4() {
        return strtoupper(sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            (mt_rand(0, 0x0fff) | 0x4000),
            (mt_rand(0, 0x3fff) | 0x8000),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        ));
    }
}