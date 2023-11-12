<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Image;
use App\Models\Manufacturer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Generate properties based on the received directives.
     *
     * @param array $directives
     *
     * @return array
     */
    protected function randomProperties(array $directives): array
    {
        $result = [];
        foreach ($directives as $key => $options) {
            if ($options[0] === 'value') {
                [, $name, $display, $min, $max, $unit] = $options;
                $temporaryMultiplier = $options[6] ?? 1;
                $value = ((float) rand($min * $temporaryMultiplier, $max * $temporaryMultiplier)) / $temporaryMultiplier;
                $result[$key] = ['name' => $name, 'value' => $value.$unit, 'display' => $display];
            } elseif ($options[0] === 'choice') {
                [, $name, $display] = $options;
                $choices = array_splice($options, 3);
                $result[$key] = ['name' => $name, 'value' => $choices[array_rand($choices)], 'display' => $display];
            }
        }
        return $result;
    }

    /**
     * Render properties into name.
     *
     * @param array $properties
     * @param string $name
     *
     * @return string
     */
    protected function propsInName(array $properties, string $name): string
    {
        if (count($properties) === 0) return $name;
        $renderedProperties = [];
        foreach ($properties as $propertyValue) {
            [
                'value' => $value,
                'display' => $display
            ] = $propertyValue;
            if ($display !== true) continue;

            $renderedProperties[] = $value;
        }
        return $name.' '.implode(' ', $renderedProperties);
    }

    /**
     * Render product name based on its parent Category.
     *
     * @param App\Models\Category $category
     * @param array $properties
     *
     * @return string
     */
    protected function renderName(Category $category, array $properties): string
    {
        $words = explode(' ', $category->name);
        $replacement = '';
        if ($category->topLevelParent()->grammatical_gender == 'M') {
            $words[0] = mb_substr($words[0], 0, mb_strlen($words[0]) - 1);
            $replacement = 'y';
        } else {
            $words[0][mb_strlen($words[0]) - 1] = 'a';
            $replacement = 'a';
        }
        for ($index = 1; $index < count($words); $index++) {
                $word = &$words[$index];
                $word = preg_replace('/[aąeęioóuy]$/i', $replacement, $word);
            }
        $name =  implode(' ', $words);

        return $this->propsInName($properties, $name);
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'warranty_period' => rand(2, 6),
            'number_in_stock' => rand(100, 1000)
        ];
    }

    /**
     * Further configure the model's state after receiving all properties.
     *
     * @return Database\Factories\ProductFactory
     */
    public function configure(): ProductFactory
    {
        return $this->afterMaking(function (Product $product) {
            $category = $product->category ?? Category::isLeaf()->inRandomOrder()->first();
            $manufacturer = $product->manufacturer ?? Manufacturer::inRandomOrder()->first();
            $directives = match($category->topLevelParent()->code) {
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
                                'kolor',
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
            $properties = $this->randomProperties($directives);
            $price = array_splice($properties, 0, 1)['price']['value'];
            $name = $this->renderName($category, $properties);

            $product->category()->associate($category);
            $product->manufacturer()->associate($manufacturer);

            $product->name = $name;
            $product->details = json_encode($properties);
            $product->price = $price;
            $product->save();

            $limit = rand(1, 3);
            $images = new Collection();
            for ($index = 0; $index < $limit; $index++) {
                $image = new Image();
                $image->origin = 'https://placehold.co/';
                $image->name = '200?text=' . $index;
                if ($index === 0) $image->thumbnail = true;
                $images->push($image);
            }
            $product->images()->saveMany($images);

        });
    }
}
