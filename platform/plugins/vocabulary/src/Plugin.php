<?php

namespace Botble\Vocabulary;

use Illuminate\Support\Facades\Schema;
use Botble\PluginManagement\Abstracts\PluginOperationAbstract;

class Plugin extends PluginOperationAbstract
{
    public static function remove()
    {
        Schema::dropIfExists('vocabularies');
        Schema::dropIfExists('vocabularies_translations');
    }
}
