<?php

namespace common\models;

use common\components\M;
use yii\elasticsearch\ActiveRecord;

class Book extends ActiveRecord
{
    /**
     * @return array This model's mapping
     */
    public static function setting()
    {
        return [
            'number_of_shards' => 1,
            'number_of_replicas' => 0,
            'analysis' => [
                'filter' => [
                    'shingle' => [
                        'type' => 'shingle'
                    ],
                    'app_ngram' => [
                        'type' => "nGram",
                        'min_gram' => 3,
                        'max_gram' => 20
                    ],
                    'stopwords' => [
                        'type' => 'stop',
                        'stopwords' => ['_french_'],
                        'igrore_case' => true,
                    ]
                ],
                'analyzer' => [
                    'reuters' => [
                        'type' => 'custom',
                        'tokenizer' => 'nGram',
                        'filter' => ['lowercase', 'stop', 'kstem']
                    ],
                    'app_analyzer' => [
                        'type' => 'custom',
                        'tokenizer' => 'nGram',
                        'filter' => ['stopwords', 'app_ngram', 'asciifolding', 'lowercase', 'snowball']
                    ],
                    'app_search_analyzer' => [
                        'type' => 'custom',
                        'tokenizer' => 'standard',
                        'filter' => ['stopwords', 'app_ngram', 'asciifolding', 'lowercase', 'snowball']
                    ]
                ],
                'tokenizer' => [
                    'nGram' => [
                        'type' => "nGram",
                        'min_gram' => 3,
                        'max_gram' => 20
                    ]
                ],
            ]
        ];
    }

    public static function mapping()
    {
        return [
            static::type() => [
                'properties' => [
                    'vendor' => [
                        'type' => 'text',
                        'analyzer' => 'reuters',
                    ],
                    'name' => [
                        'type' => 'text',
                        'analyzer' => 'reuters',
                    ],
                    'long_name' => [
                        'type' => 'text',
                        'analyzer' => 'reuters',
                    ],
                    'description' => [
                        'type' => 'text',
                        'analyzer' => 'reuters',
                    ],
                    'price' => [
                        'type' => 'long',
                        //'analyzer' => 'reuters',
                    ],
                    'store' => [
                        'type' => 'long',
                        //'analyzer' => 'reuters',
                    ],
                    'catalog' => [
                        'type' => 'long',
                        //'analyzer' => 'reuters',
                    ],
                ]
                /*/
                'properties' => [
                    'id' => ['type' => 'long'],
                    'name' => ['type' => 'string'],
                    'author_name' => ['type' => 'string'],
                    'publisher_name' => ['type' => 'string'],
                    'created_at' => ['type' => 'long'],
                    'updated_at' => ['type' => 'long'],
                    'status' => ['type' => 'long'],
                ]
                //*/
            ],
        ];
    }

    /**
     * Set (update) mappings for this model
     */
    public static function updateMapping()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->setMapping(static::index(), static::type(), static::mapping());
    }

    /**
     * Create this model's index
     */
    public static function createIndex()
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $index = static::index();
        M::printr($index, '$index');
        $type = static::type();
        M::printr($type, '$type');
        //exit;
        $command->createIndex(static::index(), [
            'settings' => static::setting(),
            'mappings' => static::mapping(),
//'warmers' => [ /* ... */ ],
//'aliases' => [ /* ... */ ],
//'creation_date' => '...'
        ]);
    }

    /**
     * Delete this model's index
     */
    public static function deleteIndex($indexForDel = false)
    {
        $db = static::getDb();
        $command = $db->createCommand();
        $index = static::index();
        if ($indexForDel) {
            $index = $indexForDel;
        }
        $command->deleteIndex($index, static::type());
    }
}