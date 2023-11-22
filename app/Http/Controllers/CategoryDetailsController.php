<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class CategoryDetailsController extends Controller
{
    public static function matchDirectives(Category $category): array {
        return match($category->topLevelParent()->code) {
            'kon' => [
                'price' => [
                    'value',
                    'cena',
                    false,
                    1,
                    20,
                    null,
                    100
                ],
                'capacitance' => [
                    'value',
                    'pojemność',
                    true,
                    1,
                    200,
                    'µF'
                ],
                'voltage' => [
                    'value',
                    'napięcie pracy',
                    true,
                    2,
                    20,
                    'V'
                ],
                'assembly' => [
                    'choice',
                    'montaż',
                    true,
                    'przewlekany',
                    'powierzchniowy'
                ]
            ],
            'rez' => [
                'price' => [
                    'value',
                    'cena',
                    false,
                    1,
                    20,
                    null,
                    100
                ],
                'resistance' => [
                    'value',
                    'rezystancja',
                    true,
                    1,
                    200,
                    'Ω'
                ],
                'tolerance' => [
                    'value',
                    'tolerancja',
                    true,
                    1,
                    20,
                    '%'
                ],
                'voltage' => [
                    'value',
                    'napięcie znamionowe',
                    true,
                    2,
                    20,
                    'V'
                ],
                'power' => [
                    'value',
                    'moc znamionowa',
                    true,
                    0,
                    2,
                    'W',
                    1000
                ],
                'assembly' => [
                    'choice',
                    'montaż',
                    true,
                    'przewlekany',
                    'powierzchniowy'
                ]
            ],
            'sil' => array_merge(
                [
                    'price' => [
                        'value',
                        'cena',
                        false,
                        1,
                        20,
                        null,
                        100
                    ],
                ],
                match($category->code) {
                    'bez' => [
                        'diameter' => [
                            'value',
                            'średnica',
                            true,
                            100,
                            300,
                            'mm'
                        ],
                        'length' => [
                            'value',
                            'głębokość',
                            true,
                            10,
                            30,
                            'mm'
                        ],
                        'turns' => [
                            'value',
                            'liczba zwojów',
                            true,
                            2,
                            10,
                            'T',
                            10
                        ],
                        'rpmPerVolt' => [
                            'value',
                            'RPM na wolt',
                            true,
                            1000,
                            3000,
                            'kv'
                        ],
                        'rpm' => [
                            'value',
                            'maksymalne obroty',
                            true,
                            50_000,
                            60_000,
                            'RPM'
                        ]
                    ],
                    'ser' => [
                        'power' => [
                            'value',
                            'moc',
                            true,
                            20,
                            200,
                            'W'
                        ],
                        'voltage' => [
                            'value',
                            'napięcie znamionowe',
                            true,
                            10,
                            30,
                            'V'
                        ],
                        'amperage' => [
                            'value',
                            'prąd ciągły',
                            true,
                            1,
                            5,
                            'A'
                        ],
                        'rpm' => [
                            'value',
                            'maksymalne obroty',
                            true,
                            1000,
                            3000,
                            'RPM'
                        ],
                        'torque' => [
                            'value',
                            'moment obrotowy',
                            true,
                            0,
                            1,
                            'Nm',
                            100
                        ]
                    ],
                    'kro' => [
                        'power' => [
                            'value',
                            'moc',
                            true,
                            2,
                            20,
                            'W'
                        ],
                        'voltage' => [
                            'value',
                            'napięcie znamionowe',
                            true,
                            5,
                            10,
                            'V'
                        ],
                        'amperage' => [
                            'value',
                            'prąd ciągły',
                            true,
                            1,
                            5,
                            'A',
                            10
                        ],
                        'step' => [
                            'value',
                            'kroków na obrót',
                            true,
                            200,
                            400,
                            ' kroków'
                        ],
                        'torque' => [
                            'value',
                            'moment obrotowy',
                            true,
                            0,
                            1,
                            'Nm',
                            10000
                        ]
                    ]
                }
            ),
            'cew' => [
                'price' => [
                    'value',
                    'cena',
                    false,
                    1,
                    20,
                    null,
                    100
                ],
                'inductance' => [
                    'value',
                    'indukcyjność',
                    true,
                    1,
                    2000,
                    'µH',
                    1000
                ],
                'voltage' => [
                    'value',
                    'napięcie pracy',
                    true,
                    2,
                    20,
                    'V'
                ]
            ],
            'trf' => [
                'price' => [
                    'value',
                    'cena',
                    false,
                    1,
                    20,
                    null,
                    100
                ],
                'primaryVoltage' => [
                    'value',
                    'napięcie pierwotne',
                    true,
                    1,
                    20,
                    'V'
                ],
                'primaryAmperage' => [
                    'value',
                    'prąd pierwotny',
                    true,
                    1,
                    20,
                    'A'
                ],
                'primaryTurns' => [
                    'value',
                    'liczba zwojów uzwojenia pierwotnego',
                    true,
                    1000,
                    2000,
                    null
                ],
                'secondaryVoltage' => [
                    'value',
                    'napięcie wtórne',
                    true,
                    1,
                    20,
                    'V'
                ],
                'secondaryAmperage' => [
                    'value',
                    'prąd wtórny',
                    true,
                    1,
                    20,
                    'A'
                ],
                'secondaryTurns' => [
                    'value',
                    'liczba zwojów uzwojenia wtórnego',
                    true,
                    1000,
                    2000,
                    null
                ],
            ],
            'dio' => array_merge(
                [
                    'price' => [
                        'value',
                        'cena',
                        false,
                        1,
                        20,
                        null,
                        100
                    ],
                    'amperage' => [
                        'value',
                        'maksymalny prąd przewodzenia',
                        true,
                        1,
                        20,
                        'A'
                    ],
                    'voltage' => [
                        'value',
                        'napięcie przewodzenia',
                        true,
                        1,
                        20,
                        'V'
                    ],
                ],
                match ($category->code) {
                    'pro' => [
                        'backVoltage' => [
                            'value',
                            'maksymalne napięcie wsteczne',
                            false,
                            1,
                            20,
                            'V'
                        ],
                        'loss' => [
                            'value',
                            'maksymalna moc strat',
                            false,
                            1,
                            20,
                            'W'
                        ],
                    ],
                    'led' => [
                        'wavelength' => [
                            'value',
                            'długość fali',
                            true,
                            400,
                            700,
                            'nm'
                        ],
                        'color' => [
                            'choice',
                            'barwa światła',
                            true,
                            'fioletowa',
                            'niebieska',
                            'zielona',
                            'żółta',
                            'czerwona'
                        ],
                        'brightness' => [
                            'value',
                            'jasność',
                            true,
                            200,
                            400,
                            'lm'
                        ],
                        'cri' => [
                            'value',
                            'współczynnik odzwierciedlenia barw',
                            false,
                            80,
                            90,
                            null
                        ],
                    ]
                },
                [
                    'assembly' => [
                        'choice',
                        'montaż',
                        true,
                        'przewlekany',
                        'powierzchniowy'
                    ]
                ]
            ),
            'trn' => [
                'price' => [
                    'value',
                    'cena',
                    false,
                    1,
                    20,
                    null,
                    100
                ],
                'voltage' => [
                    'value',
                    'napięcie baza-emiter',
                    true,
                    1,
                    10,
                    'V',
                    10
                ],
                'baseAmperage' => [
                    'value',
                    'prąd bazy',
                    false,
                    1,
                    10,
                    'A',
                    10
                ],
                'collectorAmperage' => [
                    'value',
                    'prąd kolektora',
                    false,
                    1,
                    10,
                    'A',
                    10
                ],
                'emitterAmperage' => [
                    'value',
                    'prąd emitera',
                    false,
                    1,
                    10,
                    'A',
                    10
                ],
                'assembly' => [
                    'choice',
                    'montaż',
                    true,
                    'przewlekany',
                    'powierzchniowy'
                ]
            ]
        };
    }

    /**
     * Generate properties based on the received directives.
     *
     * @param array $directives
     *
     * @return array
     */
    public static function randomizeProperties(array $directives): array
    {
        $result = [];
        foreach ($directives as $key => $options) {
            if ($options[0] === 'value') {
                [, $name, $display, $min, $max, $unit] = $options;
                $temporaryMultiplier = $options[6] ?? 1;
                $value = ((float) rand($min * $temporaryMultiplier, $max * $temporaryMultiplier)) / $temporaryMultiplier;
                $result[$key] = ['name' => $name, 'value' => $value, 'display' => $display, 'unit' => $unit];
            } elseif ($options[0] === 'choice') {
                [, $name, $display] = $options;
                $choices = array_splice($options, 3);
                $result[$key] = ['name' => $name, 'value' => $choices[array_rand($choices)], 'display' => $display];
            }
        }
        return $result;
    }

    /**
     * Get min and max or choices for each Category property.
     *
     * @param \App\Models\Category $category
     *
     * @return array
     */
    public static function getPropertyRanges(Category $category): array
    {
        $directives = self::matchDirectives($category);
        $result = [
            'manufacturer' => [
                'type' => 'choice',
                'name' => 'producent',
                'choices' => $category->products->map(
                    fn (Product $product) => $product->manufacturer->name
                )->unique()
            ]
        ];
        foreach ($directives as $key => $directive) {
            $jsonPath = 'details->'.$key.'->value';
            if ($directive[0] === 'value') {
                [$type, $name, , , , $unit] = $directive;
                $step = $directive[6] ?? 1;
                $min = $max = 0;
                if ($key === 'price') {
                    $min = $category->products()->min('price');
                    $max = $category->products()->max('price');
                } else {
                    $min = $category->products()->selectRaw(
                        "MIN( CAST( JSON_EXTRACT( `details`, '$.{$key}.value') AS DOUBLE)) AS 'min'"
                    )->first()->min;
                    $max = $category->products()->selectRaw(
                        "MAX( CAST( JSON_EXTRACT( `details`, '$.{$key}.value') AS DOUBLE)) AS 'max'"
                    )->first()->max;
                }

                $result[$key] = [
                    'type' => $type,
                    'name' => $name,
                    'min' => $min,
                    'max' => $max,
                    'unit' => $unit,
                    'step' => $step
                ];
            } else {
                [$type, $name] = $directive;
                $choices = array_slice($directive, 3);
                $existingChoices = [];
                for ($jndex = 0; $jndex < count($choices); $jndex++) {
                    $choice = $choices[$jndex];
                    if ($category->products()->where($jsonPath, $choice)->exists()) {
                        $existingChoices[] = $choice;
                    }
                }
                $result[$key] = [
                    'type' => $type,
                    'name' => $name,
                    'choices' => $existingChoices
                ];
            }
        }
        return $result;
    }
}
