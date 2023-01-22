<?php

namespace App\Model;

class SignModel
{
    public function automaticShiftSelect(): string
    {
        $shift = "1";

        if((5 <= date('H')) && (date('H') < 13)){
            if((date('H') == 5) && (date('i') < 50)){
                $shift = "3";
            }
        }

        if((13 <= date('H')) && (date('H') < 21)){
            if((date('H') == 13) && (date('i') < 50)){
                $shift = "1";
            }
            else
                $shift = "2";
        }

        if((21 <= date('H')) || (date('H') < 5)){
            if((date('H') == 21) && (date('i') < 50)){
                $shift = "2";
            }
            else
                $shift = "3";
        }
        return $shift;
    }
}