<?php
return array(
    'api/dictionary/create' => 'dictionaryAPI/create',
    'dictionary/create' => 'dictionary/create',
    'api/registration' => 'authregAPI/registration',
    'api/login' => 'authregAPI/login',
    'dictionary/([0-9]+)/([0-9]+)' => 'dictionary/deleteWord/$1/$2',
    'dictionary/remove/([0-9]+)' => 'dictionary/removeDictionary/$1',
    'dictionary/([0-9]+)' => 'dictionary/data/$1',
    'login' => 'authreg/login',
    'logout' => 'authreg/logout',
    'registration' => 'authreg/registration',
    'profile' => 'profile/index',
);