<?php

namespace App\InfoblockTemplates;

use CfDigital\Delta\Infoblocks\Models\Infoblock;
use Spatie\ModelStates\State;

abstract class InfoblockTemplate extends State
{
        public static string $name = 'default';

        public static function getFields(Infoblock $infoblock): array
        {
            return [];
        }

        public function rules(): array
        {
            return [];
        }
}
