<?php

namespace Tests;

dataset('elasticdata', [
    'empty' => [[]],
    'withItems' => [
        [
            [
                '_source' => [
                    "id" => "30f23f61-0ecb-3137-98c2-a4f425757d53",
                    "name" => "Yellow Tromp, Quigley and Auer",
                    "description" => null,
                    "is_active" => true,
                    "created_at" => "2017-04-07T07:06:33+0000"
                ]
            ],
            [
                '_source' => [
                    "id" => "d7a92975-755f-358e-9922-e00be4190659",
                    "name" => "MidnightBlue Pollich-Kihn",
                    "description" => "Saepe doloribus laborum perferendis qui dicta sunt. Quasi facere enim fugiat perferendis error sed nihil nobis. Omnis sunt perspiciatis culpa nihil quod. Vel quasi laudantium deleniti adipisci eius voluptas.",
                    "is_active" => false,
                    "created_at" => "1997-12-05T06:39:06+0000"
                ]
            ]
        ]
    ]
]);
