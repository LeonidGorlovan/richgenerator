<?php

namespace App\Modules\RichGenerator\Backend\Controllers;

use App\Modules\RichGenerator\Backend\Data\TemplateStyleData;
use App\Modules\RichGenerator\Backend\Tables\TemplateStyleTable;
use App\Modules\RichGenerator\Models\TemplateStyle;
use CfDigital\Delta\Core\Actions\CreateAction;
use CfDigital\Delta\Core\Actions\UpdateAction;
use CfDigital\Delta\Core\Http\Controllers\Api\CRUDController;

class TemplateStyleController extends CRUDController
{
    protected string $table_class = TemplateStyleTable::class;
    protected string $model_class = TemplateStyle::class;
    protected string $data_class = TemplateStyleData::class;

    public function store(TemplateStyleData $data)
    {
        (new CreateAction())->handle($data->toArray(), new TemplateStyle);

        return response()->success();
    }

    public function update(TemplateStyleData $data, $template_style)
    {
        $template_style = TemplateStyle::where('id', $template_style)->firstOrFail();

        (new UpdateAction())->handle($data->toArray(), $template_style);

        return response()->success();
    }
}
