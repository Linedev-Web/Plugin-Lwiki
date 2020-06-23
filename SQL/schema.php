<?php

class LwikiAppSchema extends CakeSchema
{

    public $file = 'schema.php';

    public function before($event = [])
    {
        return true;
    }

    public function after($event = [])
    {
    }

    public $lwiki__ltypes = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => true, 'key' => 'primary'],
        'order' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'unsigned' => false],
        'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'unsigned' => false],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1]
        ],
        'tableParameters' => ['charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci ', 'encoding ' => 'utf8mb4', 'engine' => 'InnoDB']
    ];
    public $lwiki__lcategories_ltypes = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => true, 'key' => 'primary'],
        'ltype_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => false],
        'lcategory_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => false],
    ];
    public $lwiki__lcategories = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => true, 'key' => 'primary'],
        'order' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'unsigned' => false],
        'ltype_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => false, 'key' => 'primary'],
        'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 30, 'unsigned' => false],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1]
        ],
        'tableParameters' => ['charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci ', 'encoding ' => 'utf8mb4', 'engine' => 'InnoDB']
    ];

    public $lwiki__litems_lcategories = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => true, 'key' => 'primary'],
        'lcategory_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => false],
        'litem_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => false],
    ];
    public $lwiki__litems = [
        'id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => true, 'key' => 'primary'],
        'lcategory_id' => ['type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'unsigned' => false, 'key' => 'primary'],
        'order' => ['type' => 'integer', 'null' => true, 'default' => null, 'length' => 20, 'unsigned' => false],
        'name' => ['type' => 'string', 'null' => false, 'default' => null, 'length' => 64, 'unsigned' => false],
        'text' => ['type' => 'text', 'null' => false, 'default' => null, 'unsigned' => false],
        'indexes' => [
            'PRIMARY' => ['column' => 'id', 'unique' => 1]
        ],
        'tableParameters' => ['charset' => 'utf8mb4', 'collate' => 'utf8mb4_unicode_ci ', 'encoding ' => 'utf8mb4', 'engine' => 'InnoDB']
    ];
}