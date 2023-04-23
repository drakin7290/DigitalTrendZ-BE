<?php

namespace Botble\Vocabulary\Models;

use Botble\Base\Traits\EnumCastable;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Models\BaseModel;

class Vocabulary extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vocabularies';

    /**
     * @var array
     */
    protected $fillable = [
        'vocabulary',
        'pronunciation',
        'vietnamese',
        'stress',
        'image',
        'type',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}
