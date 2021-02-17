<?php
return array(
    'api/dictionary/create' => 'dictionaryAPI/create',
    'api/dictionary/update' => 'dictionaryAPI/update',
    'dictionary/update/([0-9]+)' => 'dictionary/update/$1',
    'dictionary/create' => 'dictionary/create',
    'dictionary/add' => 'dictionary/add',
    'dictionary/([0-9]+)/([0-9]+)' => 'dictionary/deleteWord/$1/$2',
    'dictionary/remove/([0-9]+)' => 'dictionary/removeDictionary/$1',
    'dictionary/([0-9]+)' => 'dictionary/data/$1',
    'api/registration' => 'authregAPI/registration',
    'api/login' => 'authregAPI/login',
    'login' => 'authreg/login',
    'logout' => 'authreg/logout',
    'registration' => 'authreg/registration',
    'profile' => 'profile/index',
);