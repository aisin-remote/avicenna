<?php

return [
    "dowa_part_code" => env('DOWA_PART_CODE', '08'),
    "production_lines" => env('PRODUCTION_LINE') ? explode(',', env('PRODUCTION_LINE')) : []
];