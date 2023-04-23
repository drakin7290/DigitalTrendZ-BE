<?php

namespace Botble\Vocabulary\Http\Controllers\API;

// use Botble\Base\Events\BeforeEditContentEvent;
// use Botble\Vocabulary\Http\Requests\VocabularyRequest;
use Botble\Vocabulary\Repositories\Interfaces\VocabularyInterface;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
// use Exception;
// use Botble\Vocabulary\Tables\VocabularyTable;
// use Botble\Base\Events\CreatedContentEvent;
// use Botble\Base\Events\DeletedContentEvent;
// use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
// use Botble\Vocabulary\Forms\VocabularyForm;
// use Botble\Base\Forms\FormBuilder;
use Botble\Media\Services\UploadsManager;
use Botble\Vocabulary\Models\Vocabulary;

class VocabularyController extends BaseController
{
    /**
     * @var VocabularyInterface
     */
    protected $vocabularyRepository;

    /**
     * @var UploadsManager
     */
    protected $uploadManager;

    /**
     * @param VocabularyInterface $vocabularyRepository
     * @param UploadsManager $uploadManager
     */
    public function __construct(VocabularyInterface $customersRepository, UploadsManager $uploadManager)
    {
        $this->vocabularyRepository = $customersRepository;
        $this->uploadManager = $uploadManager;
    }
    public function getListVocabularies (Request $request, BaseHttpResponse $response) {
        $records = Vocabulary::where('status', 'published')->get();
        return $response->setData($records);
    }

}
