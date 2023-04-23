<?php

namespace Botble\Vocabulary\Models;

use Botble\Base\Models\BaseModel;

class VocabularyTranslation extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vocabularies_translations';

    /**
     * @var array
     */
    protected $fillable = [
        'lang_code',
        'vocabularies_id',
        'name',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;
}
