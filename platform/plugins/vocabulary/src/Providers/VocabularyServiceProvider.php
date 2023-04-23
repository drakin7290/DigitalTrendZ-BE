<?php

namespace Botble\Vocabulary\Providers;


use Botble\Vocabulary\Models\Vocabulary;
use Illuminate\Support\ServiceProvider;
use Botble\Vocabulary\Repositories\Caches\VocabularyCacheDecorator;
use Botble\Vocabulary\Repositories\Eloquent\VocabularyRepository;
use Botble\Vocabulary\Repositories\Interfaces\VocabularyInterface;
use Illuminate\Support\Facades\Event;
use Botble\Base\Traits\LoadAndPublishDataTrait;
use Illuminate\Routing\Events\RouteMatched;

class VocabularyServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function register()
    {
        $this->app->bind(VocabularyInterface::class, function () {
            return new VocabularyCacheDecorator(new VocabularyRepository(new Vocabulary));
        });

        $this->setNamespace('plugins/vocabulary')->loadHelpers();
    }

    public function boot()
    {
        $this
            ->loadAndPublishConfigurations(['permissions'])
            ->loadMigrations()
            ->loadAndPublishTranslations()
            ->loadAndPublishViews()
            ->loadRoutes(['web', 'api']);
        if (defined('LANGUAGE_MODULE_SCREEN_NAME')) {
            if (defined('LANGUAGE_ADVANCED_MODULE_SCREEN_NAME')) {
                // Use language v2
                \Botble\LanguageAdvanced\Supports\LanguageAdvancedManager::registerModule(Vocabulary::class, [
                    'name',
                ]);
            } else {
                // Use language v1
                $this->app->booted(function () {
                    \Language::registerModule([Vocabulary::class]);
                });
            }
        }

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->registerItem([
                'id'          => 'cms-plugins-vocabulary',
                'priority'    => 5,
                'parent_id'   => null,
                'name'        => 'plugins/vocabulary::vocabulary.name',
                'icon'        => 'fa-solid fa-book',
                'url'         => route('vocabulary.index'),
                'permissions' => ['vocabulary.index'],
            ]);
        });
    }
}
