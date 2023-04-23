<?php

namespace Botble\Vocabulary\Forms;

use Botble\Base\Forms\FormAbstract;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Vocabulary\Http\Requests\VocabularyRequest;
use Botble\Vocabulary\Models\Vocabulary;

class VocabularyForm extends FormAbstract
{

    /**
     * {@inheritDoc}
     */
    
    public function buildForm()
    {
        
        $this
            ->setupModel(new Vocabulary)
            ->setValidatorClass(VocabularyRequest::class)
            ->withCustomFields()
            ->add('vocabulary', 'text', [
                'label'      => 'Vocabulary',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => 'Hello',
                    'data-counter' => 120,
                ],
            ])
            ->add('pronunciation', 'text', [
                'label'      => 'Pronunciation',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => "/heˈləʊ/",
                    'data-counter' => 120,
                ],
            ])
            ->add('stress', 'number', [
                'label'      => 'Stress',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => '1',
                    'data-counter' => 120,
                ],
            ])
            ->add('vietnamese', 'text', [
                'label'      => 'Stress',
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => 'Xin chào',
                    'data-counter' => 120,
                ],
            ])
            ->add('type', 'customSelect', [ // Change "select" to "customSelect" for better UI
                'label'      => 'Type',
                'label_attr' => ['class' => 'control-label required'], // Add class "required" if that is mandatory field
                'attr'       => [
                    'class' => 'form-control select-full',
                ],
                'choices'    => [
                    'noun' => __('Danh từ'),
                    'verb' => __('Động từ'),
                    'adjective' => __('Tính từ'),
                    'adverb' => __('Trạng từ'),
                    'preposition' => __('Giới từ'),
                ],
            ])
            ->add('image', 'mediaImage', [
                'label'      => __('Image'),
                'label_attr' => ['class' => 'control-label'],
                'help_block' => [
                    'text' => "Recommended size: 868:320 (px) ",
                    'tag' => 'p',
                    'attr' => ['class' => 'help-block']
                ],
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'form-control select-full',
                ],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
