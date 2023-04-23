<?php

return [
    [
        'name' => 'Vocabularies',
        'flag' => 'vocabulary.index',
    ],
    [
        'name'        => 'Create',
        'flag'        => 'vocabulary.create',
        'parent_flag' => 'vocabulary.index',
    ],
    [
        'name'        => 'Edit',
        'flag'        => 'vocabulary.edit',
        'parent_flag' => 'vocabulary.index',
    ],
    [
        'name'        => 'Delete',
        'flag'        => 'vocabulary.destroy',
        'parent_flag' => 'vocabulary.index',
    ],
];
