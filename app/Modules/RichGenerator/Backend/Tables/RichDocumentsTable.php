<?php

namespace App\Modules\RichGenerator\Backend\Tables;

use App\Modules\RichGenerator\Enums\TemplateEnum;
use App\Modules\RichGenerator\Models\RichDocument;
use App\Modules\RichGenerator\Models\RichDocumentBrand;
use App\Modules\RichGenerator\Models\RichDocumentLang;
use Carbon\Carbon;
use CfDigital\Delta\Core\Services\Table;
use CfDigital\Delta\Core\Support\Filters\FuzzyFilter;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class RichDocumentsTable extends Table
{
    protected const SEARCH_FIELDS = ['title', 'item'];
    protected const COLUMNS = [
        'date' => [
            'type' => 'text'
        ],
        'title' => [
            'type' => 'text'
        ],
        'item' => [
            'type' => 'text'
        ],
        'brand' => [
            'type' => 'text'
        ],
        'lang' => [
            'type' => 'text'
        ],
        'export' => [
            'type' => 'html'
        ],
        '__actions' => [
            'edit', 'delete'
        ]
    ];

    protected bool $orderable = false;

    protected string $model = RichDocument::class;

    protected function map($item): array
    {
        return [
            'id' => $item->id,
            'date' => Carbon::parse($item->created_at)->format('Y-m-d'),
            'title' => $this->text($item->title),
            'item' => $item->item,
            'brand' => RichDocumentBrand::query()->find($item->brand_id)->title ?? null,
            'lang' => RichDocumentLang::query()->find($item->lang_id)->title ?? null,
            'export' => '<a href="' . route('generator.export', $item->id) . '">' . trans('delta::fields.export') . '</a>',
        ];
    }

    protected function getBasePath(): string
    {
        return noApiRoute('generator.index');
    }

    public function getHeadActions(): ?array
    {
        return [
            'filters' => [
                [
                    'key' => 'tmpl_id',
                    'type' => 'select',
                    'label' => trans('delta::fields.tmpl_id'),
                    'options' => collect(TemplateEnum::values())->map(fn ($value, $key) => [
                        'value' => ($key+1),
                        'label' => $value,
                    ]),
                ],
                [
                    'key' => 'brand_id',
                    'type' => 'select',
                    'label' => trans('delta::fields.brand_id'),
                    'options' => RichDocumentBrand::query()->get()->map(fn ($brand) => [
                        'value' => $brand->id,
                        'label' => $brand->title,
                    ]),
                ],
                [
                    'key' => 'lang_id',
                    'type' => 'select',
                    'label' => trans('delta::fields.lang_id'),
                    'options' => RichDocumentLang::query()->get()->map(fn ($lang) => [
                        'value' => $lang->id,
                        'label' => $lang->title,
                    ]),
                ],
                [
                    'key' => 'created_at_from',
                    'type' => 'datetime',
                    'label' => trans('delta::fields.created_at_from'),
                ],
                [
                    'key' => 'created_at_to',
                    'type' => 'datetime',
                    'label' => trans('delta::fields.created_at_to'),
                ],
            ]
        ];
    }

    protected function interceptQuery(QueryBuilder $query): QueryBuilder
    {
        $query->allowedFilters([
            AllowedFilter::custom('search', new FuzzyFilter(...static::SEARCH_FIELDS), 'search'),
            'tmpl_id',
            'brand_id',
            'lang_id',
            AllowedFilter::scope('created_at_from', 'createdAtFrom'),
            AllowedFilter::scope('created_at_to', 'createdAtTo')
        ]);

        return $query;
    }
}
