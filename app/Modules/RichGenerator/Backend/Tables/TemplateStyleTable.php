<?php

namespace App\Modules\RichGenerator\Backend\Tables;

use App\Modules\RichGenerator\Models\TemplateStyle;
use Carbon\Carbon;
use CfDigital\Delta\Core\Services\Table;

class TemplateStyleTable extends Table
{
    protected const SEARCH_FIELDS = ['title', 'description'];
    protected const COLUMNS = [
        'date' => [
            'type' => 'text'
        ],
        'title' => [
            'type' => 'text'
        ],
        'description' => [
            'type' => 'text'
        ],
        '__actions' => [
            'edit', 'delete'
        ]
    ];

    protected bool $orderable = false;

    protected string $model = TemplateStyle::class;

    protected function map($item): array
    {
        return [
            'id' => $item->id,
            'date' => Carbon::parse($item->updated_at)->toDateString(),
            'title' => $this->text($item->title),
            'description' => $this->text($item->description),
        ];
    }

    protected function getBasePath(): string
    {
        return noApiRoute('templatestyle.index');
    }
}
