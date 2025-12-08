<?php

return [

    "required" => "A(z) :attribute mező nem lehet üres.",
    "alpha_num" => "A(z) :attribute mező csak betű és szám lehet.",
    'between' => [
        'array' => 'The :attribute az elemei száma :min és :max között lehet.',
        'file' => 'The :attribute nagysága :min és :max kilobyt között lehet.',
        'numeric' => 'The :attribute :min és :max érték között kell lennie.',
        'string' => 'The :attribute mező hossza :min és :max karakter között lehet.',
    ],
    "unique" => "A(z) :attribute már létezik.",
    "max_digits" => "A(z) :attribute mező nemlehet hosszabb mint :max",
    "numeric" => "A(z) :attribute mező csak szám lehet."
];