<?php

namespace App\Modules\RichGenerator\Backend\Data;

use CfDigital\Delta\Core\Services\CRUDFormGenerator;
use CfDigital\Delta\Core\Services\Data;
use Illuminate\Database\Eloquent\Model;
use CfDigital\Delta\Core\Rules\ImageRule;

class RichDocumentBrandData extends Data
{
    public function __construct(
        public string $title,
    )
    {
    }

    public static function rules(): array
    {
        return [
            "title" => 'required|string|max:255',
        ];
    }

    public static function fieldsForCreation(Model $model): array
    {
        return CRUDFormGenerator::new($model, 'Default')
            ->addTextField('title', ["required" => true])
            ->get();
    }
}
