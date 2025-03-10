<?php

namespace App\Modules\RichGenerator\Backend\Data;

use CfDigital\Delta\Core\Services\CRUDFormGenerator;
use CfDigital\Delta\Core\Services\Data;
use Illuminate\Database\Eloquent\Model;

class TemplateStyleData extends Data
{
    public function __construct(
        public string $title,
        public string $description,
        public string $style,
    )
    {
    }

    public static function rules(): array
    {
        return [
            "title" => 'required|string|max:255',
            "description" => 'required|string',
            "style" => 'required|string',
        ];
    }

    public static function fieldsForCreation(Model $model): array
    {
        return CRUDFormGenerator::new($model, 'Default')
            ->addTextField('title', ["required" => true])
            ->addTextareaField('description', ["required" => true])
            ->addTextareaField('style', ["required" => true])
            ->get();
    }
}
