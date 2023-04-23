<?php

namespace Botble\Vocabulary\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Vocabulary\Http\Requests\VocabularyRequest;
use Botble\Vocabulary\Repositories\Interfaces\VocabularyInterface;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Botble\Vocabulary\Tables\VocabularyTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Vocabulary\Forms\VocabularyForm;
use Botble\Base\Forms\FormBuilder;

class VocabularyController extends BaseController
{
    /**
     * @var VocabularyInterface
     */
    protected $vocabularyRepository;

    /**
     * @param VocabularyInterface $vocabularyRepository
     */
    public function __construct(VocabularyInterface $vocabularyRepository)
    {
        $this->vocabularyRepository = $vocabularyRepository;
    }

    /**
     * @param VocabularyTable $table
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(VocabularyTable $table)
    {
        page_title()->setTitle(trans('plugins/vocabulary::vocabulary.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/vocabulary::vocabulary.create'));

        return $formBuilder->create(VocabularyForm::class)->renderForm();
    }

    /**
     * @param VocabularyRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(VocabularyRequest $request, BaseHttpResponse $response)
    {
        $vocabulary = $this->vocabularyRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(VOCABULARY_MODULE_SCREEN_NAME, $request, $vocabulary));

        return $response
            ->setPreviousUrl(route('vocabulary.index'))
            ->setNextUrl(route('vocabulary.edit', $vocabulary->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $vocabulary = $this->vocabularyRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $vocabulary));

        page_title()->setTitle(trans('plugins/vocabulary::vocabulary.edit') . ' "' . $vocabulary->name . '"');

        return $formBuilder->create(VocabularyForm::class, ['model' => $vocabulary])->renderForm();
    }

    /**
     * @param int $id
     * @param VocabularyRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, VocabularyRequest $request, BaseHttpResponse $response)
    {
        $vocabulary = $this->vocabularyRepository->findOrFail($id);

        $vocabulary->fill($request->input());

        $vocabulary = $this->vocabularyRepository->createOrUpdate($vocabulary);

        event(new UpdatedContentEvent(VOCABULARY_MODULE_SCREEN_NAME, $request, $vocabulary));

        return $response
            ->setPreviousUrl(route('vocabulary.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $vocabulary = $this->vocabularyRepository->findOrFail($id);

            $this->vocabularyRepository->delete($vocabulary);

            event(new DeletedContentEvent(VOCABULARY_MODULE_SCREEN_NAME, $request, $vocabulary));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $vocabulary = $this->vocabularyRepository->findOrFail($id);
            $this->vocabularyRepository->delete($vocabulary);
            event(new DeletedContentEvent(VOCABULARY_MODULE_SCREEN_NAME, $request, $vocabulary));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }

}
