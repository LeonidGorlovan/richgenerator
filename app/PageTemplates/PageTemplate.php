<?php

namespace App\PageTemplates;

use CfDigital\Delta\Core\Http\Resources\PageResource;
use CfDigital\Delta\Core\Http\Resources\UserResource;
use App\PageTemplates\DefaultTemplate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\State;
use CfDigital\Delta\Seo\Models\Structure;

#[
    DefaultState(DefaultTemplate::class),
]
abstract class PageTemplate extends State
{
    public function getData(Request $request, ?Model $page = null)
    {
        $structure = $this->getModel();

        if (!$page) {
            $page = config('delta.models.page')::whereHas('structures', function ($query) use ($structure) {
                $query->where('id', $structure->id);
            })->first();
        }

        $result = [
            'data' => $page ? (new PageResource($page))->toArray($request) : [],
            'meta' => Structure::where('id', $structure?->id)->withMeta()->first()->getMeta(),
            'template' => $structure->template ?? 'default',
            'impersonated' => Session::has('impersonated_id') ? new UserResource(config('delta.models.user')::find(Session::get('impersonated_id'))) : false
        ];

        if ($structure->parent_id) {
            $result['breadcrumbs'] = $structure->getFrontBreadcrumbs();
        }

        return $result;
    }

    public static function getFields(Model $page): array
    {
        return [];
    }

    public function swapVariables($text)
    {
        preg_match_all('/{{([a-zA-Z_0-9.]+)}}/', $text, $variables);

        $data = $this->variablesList();

        foreach ($variables[1] as $variable) {
            $text = str_replace('{{' . $variable . '}}', $data[$variable]['value'], $text);
        }

        return $text;
    }

    public function getGoogleJsonLdData()
    {
        $structure = $this->getModel();

        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => $structure->title,
            'url' => $structure->url,
        ];

        if ($structure->meta_description) {
            $data['description'] = $structure->meta_description;
        }

        return $data;
    }

    public function getCompendium(): string
    {
        $variables = $this->variablesList();
        $result = '<h3>Available variables:</h3>';

        foreach ($variables as $variable => $variableData) {
            $result .= '<p><span class="copy">{{' . $variable . '}}</span> - ' . $variableData['description'] . '</p>';
        }

        return $result;
    }

    protected function variablesList(): array
    {
        $model = $this->getModel();
        $withValues = $model instanceof Structure;

        if ($withValues) {
            return [

                'title' => [
                    'value' => $model->title,
                    'description' => trans('delta::meta.seo.title')
                ],
                'h1_title' => [
                    'value' => $model->h1_title ?: $model->title,
                    'description' => trans('delta::meta.seo.h1_title')
                ],
            ];
        }

        return [
            'title' => [
                'value' => null,
                'description' => trans('delta::meta.seo.title')
            ],
            'h1_title' => [
                'value' => null,
                'description' => trans('delta::meta.seo.h1_title')
            ],
        ];
    }

    public function isFilterReplacement(): bool
    {
        return false;
    }

    public static function withInData(Request $request): array
    {
        return [];
    }
}
