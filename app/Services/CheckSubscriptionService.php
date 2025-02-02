<?php

namespace App\Services;

class CheckSubscriptionService
{
    public static function checkFrequency($subscription)
    {
        if($subscription->frequency === 1){ $frequency = '1ヶ月'; }
        if($subscription->frequency === 2){ $frequency = '2ヶ月'; }
        if($subscription->frequency === 3){ $frequency = '3ヶ月'; }
        if($subscription->frequency === 6){ $frequency = '6ヶ月'; }
        if($subscription->frequency === 12){ $frequency = '1年'; }

        return $frequency;
    }
}
