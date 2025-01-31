<?php

namespace App\Modules\RichGenerator\Backend\Controllers;

use App\Modules\RichGenerator\Backend\Data\RichDocumentBrandData;
use App\Modules\RichGenerator\Backend\Tables\RichDocumentBrandsTable;
use App\Modules\RichGenerator\Models\RichDocumentBrand;
use CfDigital\Delta\Core\Actions\CreateAction;
use CfDigital\Delta\Core\Actions\UpdateAction;
use CfDigital\Delta\Core\Http\Controllers\Api\CRUDController;

class RichDocumentBrandsController extends CRUDController
{
    protected string $table_class = RichDocumentBrandsTable::class;
    protected string $model_class = RichDocumentBrand::class;
    protected string $data_class = RichDocumentBrandData::class;

    public function store(RichDocumentBrandData $data)
    {
        (new CreateAction())->handle($data->toArray(), new RichDocumentBrand);

        return response()->success();
    }

    public function update(RichDocumentBrandData $data, $rich_document_brend)
    {
        $rich_document_brend = RichDocumentBrand::where('id', $rich_document_brend)->firstOrFail();

        (new UpdateAction())->handle($data->toArray(), $rich_document_brend);

        return response()->success();
    }
}
