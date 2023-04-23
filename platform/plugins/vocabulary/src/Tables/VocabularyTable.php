<?php

namespace Botble\Vocabulary\Tables;

use Illuminate\Support\Facades\Auth;
use BaseHelper;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Vocabulary\Repositories\Interfaces\VocabularyInterface;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;
use Html;

class VocabularyTable extends TableAbstract
{

    /**
     * @var bool
     */
    protected $hasActions = true;

    /**
     * @var bool
     */
    protected $hasFilter = true;

    /**
     * VocabularyTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param VocabularyInterface $vocabularyRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, VocabularyInterface $vocabularyRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $vocabularyRepository;

        if (!Auth::user()->hasAnyPermission(['vocabulary.edit', 'vocabulary.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function ajax()
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('vocabulary', function ($item) {
                if (!Auth::user()->hasPermission('vocabulary.edit')) {
                    return $item->name;
                }
                return Html::link(route('vocabulary.edit', $item->id), $item->vocabulary);
            })
            ->editColumn('image', function ($item) {
                return $this->displayThumbnail($item->image);
            })
            ->editColumn('pronunciation', function ($item) {
                return $item->pronunciation;
            })
            ->editColumn('vietnamese', function ($item) {
                return $item->vietnamese;
            })
            ->editColumn('stress', function ($item) {
                return $item->stress;
            })
            ->editColumn('type', function ($item) {
                switch ($item->type) {
                    case 'noun':
                        return 'Danh từ';
                    case 'verb':
                        return 'Động từ';
                    case 'adjective': 
                        return 'Tính từ';
                    case 'adverb': 
                        return 'Trạng từ';
                    case 'preposition': 
                        return 'Giới từ';
                }
                return $item->type;
            })
            ->editColumn('status', function ($item) {
                return $item->status->toHtml();
            })
            ->addColumn('operations', function ($item) {
                return $this->getOperations('vocabulary.edit', 'vocabulary.destroy', $item);
            });

        return $this->toJson($data);
    }

    /**
     * {@inheritDoc}
     */
    public function query()
    {
        $query = $this->repository->getModel()
            ->select([
               'id',
               'vocabulary',
               'pronunciation',
               'vietnamese',
               'stress',
               'type',
               'image',
               'created_at',
               'status',
           ]);

        return $this->applyScopes($query);
    }

    /**
     * {@inheritDoc}
     */
    public function columns()
    {
        return [
            // 'id' => [
            //     'title' => trans('core/base::tables.id'),
            //     'width' => '20px',
            // ],
            'vocabulary' => [
                'title' => 'vocabulary',
                'class' => 'text-start',
            ],
            'image' => [
                'title' => 'Image',
                'width' => '70px',
            ],
            'pronunciation' => [
                'title' => 'Pronunciation',
                'class' => 'text-start',
            ],
            'vietnamese' => [
                'title' => 'Vietnamese',
                'class' => 'text-start',
            ],
            'stress' => [
                'title' => 'Stress',
                'class' => 'text-start',
            ],
            'type' => [
                'title' => 'Type',
                'class' => 'text-start',
            ],
            // 'created_at' => [
            //     'title' => trans('core/base::tables.created_at'),
            //     'width' => '100px',
            // ],
            'status' => [
                'title' => trans('core/base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function buttons()
    {
        return $this->addCreateButton(route('vocabulary.create'), 'vocabulary.create');
    }

    /**
     * {@inheritDoc}
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('vocabulary.deletes'), 'vocabulary.destroy', parent::bulkActions());
    }

    /**
     * {@inheritDoc}
     */
    public function getBulkChanges(): array
    {
        return [
            'name' => [
                'title'    => trans('core/base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'status' => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->getBulkChanges();
    }
}
