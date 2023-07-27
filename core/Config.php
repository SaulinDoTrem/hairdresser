<?php

    namespace app\core;

    class Config {

        public static function moneyFormat(float $number, int $countDecimals = 2, string $decimalSeparator = ",", string $thousandsSeparator = "."):string {
            $number = strval($number);

            [$naturals, $decimals] = explode(".", $number);

            $numbers = str_split($naturals);
            $number = [];

            for ($i=0; $i < count($numbers); $i++) {
                array_push($number, $numbers[$i]);
                if($i % 3 === 0 && $i != count($numbers)-1)
                    array_push($number, $thousandsSeparator);
            }

            $number = join("", $number);

            $decimals = str_split($decimals);
            $newDecimals = "";

            for($i = 0; $i < $countDecimals; $i++) {
                $newDecimals = "$newDecimals" . $decimals[$i];
            }


            return "$number$decimalSeparator$newDecimals";
        }

        public static function formatAttributeNameToColumnName(string $name): string {
            $splitName = str_split($name);

            foreach($splitName as $i => $char) {
                if($i === 0) {
                    $splitName[$i] = strtolower($char);
                }
                if(ctype_upper($char))
                    $splitName[$i] = "_" . strtolower($char);
            }

            return join($splitName);
        }
    }
?>