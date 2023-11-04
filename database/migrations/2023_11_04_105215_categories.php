<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        function isMultidimensional(array $array): bool
        {
            $keys = array_keys($array);
            for ($index = 0; $index < count($array); $index++) {
                if (is_array($array[$keys[$index]])) return true;
            }
            return false;
        }

        function flattenModelList(
            array $array,
            Callable $callback,
            array $return = [],
            array $parent = [],
            bool $isTopLevel = true
        ): array {
            foreach ($array as $key => $value) {
                if ($key === 'details') continue;
                if ($isTopLevel) {
                    $parent = [
                        'id' => null,
                        'name' => null
                    ];
                }
                if (isMultidimensional($value)) {
                    $return[] = $callback($value['details'], $key, $parent);
                    $parent = [
                        'id' => count($return),
                        'name' => $value['details']['name']
                    ];
                    $return = flattenModelList($value, $callback, $return, $parent, false);
                } else {
                    $return[] = $callback($value, $key, $parent);
                }
            }
            return $return;
        }

        $categoryTree = [
            'kon' => [
                'details' => ['name' => 'kondenstatory', 'grammaticalGender' => 'M'],
                'ele' => ['name' => 'elektrolityczne'],
                'cer' => ['name' => 'ceramiczne']
            ],
            'rez' => [
                'details' => ['name' => 'rezystory', 'grammaticalGender' => 'M'],
                'dru' => ['name' => 'drutowe'],
                'fol' => ['name' => 'foliowe'],
                'war' => [
                    'details' => ['name' => 'warstwowe'],
                    'cie' => ['name' => 'cienkowarstwowe'],
                    'gru' => ['name' => 'grubowarstwowe']
                ],
                'pot' => ['name' => 'potencjometry', 'ignoreParent' => true]
            ],
            'sil' => [
                'details' => ['name' => 'silniki', 'grammaticalGender' => 'M'],
                'bez' => ['name' => 'bezszczotkowe'],
                'kro' => ['name' => 'krokowe'],
                'ser' => ['name' => 'serwonapędy', 'ignoreParent' => true]
            ],
            'cew' => [
                'details' => ['name' => 'cewki', 'grammaticalGender' => 'F'],
                'cyl' => ['name' => 'cylindryczne'],
                'tor' => ['name' => 'toroidalne'],
                'spi' => ['name' => 'spiralne']
            ],
            'trf' => [
                'details' => ['name' => 'transformatory', 'grammaticalGender' => 'M']
            ],
            'dio' => [
                'details' => ['name' => 'diody', 'grammaticalGender' => 'F'],
                'pro' => ['name' => 'prostownicze'],
                'led' => ['name' => 'świecące']
            ],
            'trn' => [
                'details' => ['name' => 'tranzystory', 'grammaticalGender' => 'M'],
                'bip' => ['name' => 'bipolarne'],
                'pol' => ['name' => 'unipolarne']
            ]
        ];

        flattenModelList($categoryTree, function (array $categoryInfo, string $code, array $parent) {
            $category = new Category();
            if (!is_null($parent['id'])) $category->supercategory()->associate(Category::findOrFail($parent['id']));
            $name = (($categoryInfo['ignoreParent'] ?? false) ? null : $category->topLevelParent()->name.(is_null($category->topLevelParent()->name) ? '' : ' ')) . $categoryInfo['name'];
            $category->name = $name;
            $category->code = $code;
            $category->grammatical_gender = $categoryInfo['grammaticalGender'] ?? null;
            $category->save();
            return $category;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Category::truncate();
    }
};
