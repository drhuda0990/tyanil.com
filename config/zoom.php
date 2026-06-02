<?php

return [
    'api_key' => 'R8sabhNpRb-bA5nwrAhGWg',
    'api_secret' => 'GtwLG9yLInNof8sTLkJ55KfOCnIFoE4NNXAo',
    'base_url' => 'https://api.zoom.us/v2/',
    'token_life' => 60 * 60 * 24 * 7, // In seconds, default 1 week
    'authentication_method' => 'jwt', // Only jwt compatible at present but will add OAuth2
    'max_api_calls_per_request' => '5' ,// how many times can we hit the api to return results for an all() request
'auto_recording'=> true,


];
