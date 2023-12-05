<?php

namespace App\Services;

class MyServices
{

   public static function incrementSerialNumber($serialNumber) {
    // Extract the numeric part of the serial number
    preg_match('/(\d+)$/', $serialNumber, $matches);
    $numericPart = isset($matches[1]) ? $matches[1] : 0;

    // Increment the numeric part
    $newNumericPart = $numericPart + 1;

    // Pad the numeric part with zeros to maintain the same length
    $paddedNumericPart = str_pad($newNumericPart, strlen($numericPart), '0', STR_PAD_LEFT);

    // Replace the numeric part in the original serial number
    $newSerialNumber = preg_replace('/\d+$/', $paddedNumericPart, $serialNumber);

    return $newSerialNumber;
}

    public static function preventNullsFromArray($arrayKey, $array,$return='')
   {

        if(array_key_exists($arrayKey,$array))
            return strval($array[$arrayKey]);

        else return $return;
   }

   public static function zeroIfNullOrBlank($arrayKey, $array,$return='')
   {

        if(array_key_exists($arrayKey,$array))
            return floatval(strval($array[$arrayKey]));

        else return $return;
   }

}
