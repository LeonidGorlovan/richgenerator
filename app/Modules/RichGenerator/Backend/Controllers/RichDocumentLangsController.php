<?php

namespace App\Modules\RichGenerator\Backend\Controllers;


use App\Modules\RichGenerator\Backend\Data\RichDocumentLangData;
use App\Modules\RichGenerator\Backend\Tables\RichDocumentLangsTable;
use App\Modules\RichGenerator\Models\RichDocumentLang;
use CfDigital\Delta\Core\Actions\CreateAction;
use CfDigital\Delta\Core\Actions\UpdateAction;
use CfDigital\Delta\Core\Http\Controllers\Api\CRUDController;

class RichDocumentLangsController extends CRUDController
{
    protected string $table_class = RichDocumentLangsTable::class;
    protected string $model_class = RichDocumentLang::class;
    protected string $data_class = RichDocumentLangData::class;

    public function store(RichDocumentLangData $data)
    {
        (new CreateAction())->handle($data->toArray(), new RichDocumentLang);

        return response()->success();
    }

    public function update(RichDocumentLangData $data, $rich_document_lang)
    {
        $rich_document_lang = RichDocumentLang::where('id', $rich_document_lang)->firstOrFail();

        (new UpdateAction())->handle($data->toArray(), $rich_document_lang);

        return response()->success();
    }
}
