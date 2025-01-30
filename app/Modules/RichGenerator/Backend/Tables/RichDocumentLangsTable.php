<?php

namespace App\Modules\RichGenerator\Backend\Tables;

use App\Modules\RichGenerator\Models\RichDocumentLang;
use CfDigital\Delta\Core\Services\Table;
use Illuminate\Http\Request;

class RichDocumentLangsTable extends Table
{
    protected const COLUMNS = [
        'title' => [
            'type' => 'text'
        ],
        '__actions' => [
            'edit', 'delete'        ]
    ];

    protected bool $orderable = false;

    protected string $model = RichDocumentLang::class;

    protected function map($item): array
    {
        return [
            'id' => $item->id,
            'title' => $this->text($item->title),
        ];
    }

    protected function getBasePath(): string
    {
        return noApiRoute('langs.index');
    }
}
