<?php
$patterns = [
    'ukrphone' => [
       'regex' => '/^[5-9][0-9]{8}$/',
       'callback' => function ($matches) {
           printme($matches);
           return '+380' . implode($matches);
       }
    ],
    'latemail' => [
        'regex' => '/^[a-z0-9_.-]+@[a-z0-9-]+[.][a-z0-9-.]+$/'
    ] 
];