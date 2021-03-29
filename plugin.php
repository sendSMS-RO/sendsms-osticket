<?php
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__file__) . '/include');
return array(
    'id' => 'sendsms:messaging', # notrans
    'version' => '0.1',
    'name' => 'sendSMS',
    'author' => 'Radu Vasile Catalin',
    'description' => 'Use our SMS shipping solution to deliver the right information at the right time.',
    'url' => 'https://www.sendsms.ro/en/', #temporat
    'plugin' => 'sendsms.php:SendSMS'
);
