<?php

namespace App\PageTemplates;

class DefaultTemplate extends PageTemplate
{
    public static string $name = 'default';

    public function getGoogleJsonLdData()
    {
        $data = parent::getGoogleJsonLdData();

        $data['@type'] = 'WebPage';

        return $data;
    }
}
