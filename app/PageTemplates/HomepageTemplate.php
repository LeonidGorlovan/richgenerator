<?php

namespace App\PageTemplates;

//use App\Modules\Sliders\Models\Slider;
//use CfDigital\Delta\Core\Services\CRUDFormGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class HomepageTemplate extends PageTemplate
{
    public static string $name = 'homepage';

    public function getData(Request $request, ?Model $page = null)
    {
        $page = $page ?: config('delta.models.domain')::where('name', getDomainName($request))->firstOrFail();

        return parent::getData($request, $page);
    }

    public static function getFields(Model $page): array
    {
        return [];
//        return CRUDFormGenerator::new($page)
//            ->tabless()
//            ->addSelectField('slider_id', [
//                'value' => $page->slider_id,
//                'data' => Slider::select(['title', 'id'])->get()->toSelect()
//            ])
//            ->get();
    }

    public static function rules(): array
    {
        return [
//            'slider_id' => 'nullable|exists:sliders,id'
        ];
    }

    public function getGoogleJsonLdData()
    {
        $data = parent::getGoogleJsonLdData();

        $data['@type'] = 'Organization';
//        $data['logo'] = $this->structure->logo;

        return $data;
    }
}
