<?php

namespace App\PageTemplates;

class generatorInnerPage extends PageTemplate
{
    public static string $name = 'default';

    public function getGoogleJsonLdData()
    {
        $data = parent::getGoogleJsonLdData();

        $data['@type'] = 'WebPage';

        return $data;
    }
}
