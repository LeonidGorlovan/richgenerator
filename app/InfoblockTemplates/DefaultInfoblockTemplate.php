<?php

namespace App\InfoblockTemplates;

use CfDigital\Delta\Core\Services\Fields\RepeaterTemplate;
use CfDigital\Delta\Core\Services\Fields\TextTemplate;
use CfDigital\Delta\Infoblocks\Models\Infoblock;

class DefaultInfoblockTemplate extends InfoblockTemplate
{
    public static string $name = 'default';

    public static function getFields(Infoblock $infoblock): array
    {
        return [
            'quote' => TextTemplate::prepareTranslated(
                label: trans('delta::fields.quote'),
                value: $infoblock->data['quote'] ?? null,
                additional: ['required' => true]
            ),
            'blocks' => RepeaterTemplate::prepare(
                label: trans('delta::fields.blocks'),
                value: $infoblock->data['blocks'] ?? null,
                additional: [
                    'required' => true,
                    'data' => [
                        'title' => TextTemplate::prepareTranslated(
                            label: trans('delta::fields.title'),
                            additional: ['required' => true]
                        )
                    ]
                ]
            )
        ];
    }

    public function rules(): array
    {
        return [
            'quote.' . default_locale() => 'max:250|string|required',
            'blocks.*.title.' . default_locale() => 'max:250|string|required',
        ];
    }
}
