<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Allowed agency for Marina / Skyline payment calculators
    |--------------------------------------------------------------------------
    |
    | Only users with agency_id matching this value (or the agency user whose
    | id matches) may access the calculators. Set via PAYMENT_CALCULATOR_AGENCY_ID in .env.
    |
    */

    'allowed_agency_id' => (int) env('PAYMENT_CALCULATOR_AGENCY_ID', 486),

];
