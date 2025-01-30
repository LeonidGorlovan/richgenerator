<?php

namespace App\Modules\RichGenerator\Backend\Data;

use App\Modules\RichGenerator\Enums\TemplateEnum;
use App\Modules\RichGenerator\Models\RichDocumentBrand;
use App\Modules\RichGenerator\Models\RichDocumentLang;
use CfDigital\Delta\Core\Enums\PublishStatus;
use CfDigital\Delta\Core\Services\CRUDFormGenerator;
use CfDigital\Delta\Core\Services\Data;
use Illuminate\Database\Eloquent\Model;

class RichDocumentData extends Data
{
    public function __construct(
        public string $title,
        public string $item,
        public string $html,
        public int $tmpl_id,
        public int $brand_id,
        public int $lang_id,
        public PublishStatus|null $status,
    )
    {
    }

    public static function rules(): array
    {
        return [
            "title" => 'required|string|max:255',
            "item" => 'required|string|max:255',
            "html" => 'required',
            "tmpl_id" => 'required|numeric',
            "brand_id" => 'required|numeric',
            "lang_id" => 'required|numeric',
            'status' => 'required',
        ];
    }

    public static function fieldsForCreation(Model $model): array
    {
        return CRUDFormGenerator::new($model, 'Default')
            ->addTextField('title', ["required" => true])
            ->addTextField('item', ["required" => true])
            ->addEditorField('html', ["required" => true, 'json' => false])
            ->addSelectField('tmpl_id', [
                "required" => true,
                "options" => collect(TemplateEnum::values())->map(fn ($value, $key) => [
                    'value' => ($key+1),
                    'label' => $value,
                ]),
                "value" => $model->tmpl_id,
            ])
            ->addSelectField('brand_id', [
                "required" => true,
                "options" => RichDocumentBrand::query()->get()->map(fn ($brand) => [
                    'value' => $brand->id,
                    'label' => $brand->title,
                ]),
                "value" => $model->brand_id,
            ])
            ->addSelectField('lang_id', [
                "required" => true,
                "options" => RichDocumentLang::query()->get()->map(fn ($lang) => [
                    'value' => $lang->id,
                    'label' => $lang->title,
                ]),
                "value" => $model->lang_id,
            ])
            ->addStatusField()
            ->get();
    }
}
