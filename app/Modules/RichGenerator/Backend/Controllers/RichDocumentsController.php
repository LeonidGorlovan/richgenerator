<?php

namespace App\Modules\RichGenerator\Backend\Controllers;


use App\Modules\RichGenerator\Backend\Data\RichDocumentData;
use App\Modules\RichGenerator\Backend\Tables\RichDocumentsTable;
use App\Modules\RichGenerator\Models\RichDocument;
use App\Modules\RichGenerator\Services\ParseHtmlService;
use CfDigital\Delta\Core\Actions\CreateAction;
use CfDigital\Delta\Core\Actions\UpdateAction;
use CfDigital\Delta\Core\Http\Controllers\Api\CRUDController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class RichDocumentsController extends CRUDController
{
    protected string $table_class = RichDocumentsTable::class;
    protected string $model_class = RichDocument::class;
    protected string $data_class = RichDocumentData::class;

    public function store(RichDocumentData $data)
    {
        (new CreateAction())->handle($data->toArray(), new RichDocument);

        return response()->success();
    }

    public function update(RichDocumentData $data, $rich_document)
    {
        $rich_document = RichDocument::where('id', $rich_document)->firstOrFail();

        (new UpdateAction())->handle($data->toArray(), $rich_document);

        return response()->success();
    }

    public function export(int $id): ?BinaryFileResponse
    {
        return (new ParseHtmlService())->downloadArchive($id);
    }
}
