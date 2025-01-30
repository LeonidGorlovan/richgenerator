<?php

namespace App\Modules\RichGenerator\Backend\Tables;

use App\Modules\RichGenerator\Models\RichDocumentBrand;
use CfDigital\Delta\Core\Services\Table;
use Illuminate\Http\Request;

class RichDocumentBrandsTable extends Table
{
    protected const COLUMNS = [
        'title' => [
            'type' => 'text'
        ],
        '__actions' => [
            'edit', 'delete'
        ]
    ];

    protected bool $orderable = false;

    protected string $model = RichDocumentBrand::class;

    protected function map($item): array
    {
        return [
            'id' => $item->id,
            'title' => $this->text($item->title),
        ];
    }

    protected function getBasePath(): string
    {
        return noApiRoute('brands.index');
    }
}
