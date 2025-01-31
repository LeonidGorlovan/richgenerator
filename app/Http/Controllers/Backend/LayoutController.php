<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use CfDigital\Delta\Core\Services\UploadImageService;
use CfDigital\Delta\Core\Http\Requests\UploadImageRequest;
use CfDigital\Delta\Core\Support\BackendMenu;
use Illuminate\Http\Request;

class LayoutController extends Controller
{
    public function __invoke(Request $request)
    {
        $locales = [];
        foreach (config('delta.supportedLocales') as $locale => $arr) {
            $locales[] = [
                ...$arr,
                'is_default' => default_locale() === $locale,
                'locale' => $locale
            ];
        }

        return [
            'menu' => $this->menu($request),
            'locales' => $locales
        ];
    }

    private function menu(Request $request)
    {
        $user = $request->user();

        return BackendMenu::new($user)
            ->addItem(
                title: trans('delta::menu.users'),
                name: 'users',
                icon: 'person',
                items: BackendMenu::new($user)
                    ->addItem(title: trans('delta::menu.users'), permission: 'view user', url: noApiRoute('users.index'))
                    ->addItem(title: trans('delta::menu.roles'), permission: 'view role', url: noApiRoute('roles.index'))->get()
            )
            ->addItem(title: trans('delta::menu.pages'), permission: 'view domain', name: 'pages', url: noApiRoute('domains.index'), icon: 'web')
            ->addItem(title: trans('delta::menu.menu'), permission: 'view menu', name: 'menu', url: noApiRoute('menus.index'), icon: 'menu')

            ->addItem(
                title: trans('delta::menu.rich_generator'),
                name: 'rich_generator',
                icon: 'web',
                items: BackendMenu::new($user)
                    ->addItem(title: trans('delta::menu.rich_generator_documents'), permission: 'view rich_generator', url: noApiRoute('generator.index'))
                    ->addItem(title: trans('delta::menu.rich_generator_brands'), permission: 'view rich_generator', url: noApiRoute('brands.index'))
                    ->addItem(title: trans('delta::menu.rich_generator_langs'), permission: 'view rich_generator', url: noApiRoute('langs.index'))
                    ->addItem(title: trans('delta::menu.template_styles'), permission: 'view template_styles', url: noApiRoute('templatestyle.index'))
                    ->get()
            )

            ->addItem(title: trans('delta::menu.infoblocks'), permission: 'view infoblock', name: 'infoblocks', url: noApiRoute('infoblocks.index'), icon: 'polyline')
            ->addItem(title: trans('delta::menu.forms'), permission: 'view form', name: 'forms', url: noApiRoute('forms.index'), icon: 'vertical_split')
            ->addItem(title: trans('delta::menu.seo'), name: 'seo', icon: 'search', items: BackendMenu::new($user)
                ->addItem(title: trans('delta::menu.structures'), permission: 'view structure', url: noApiRoute('structures.index'))
                ->addItem(title: trans('delta::menu.redirects'), permission: 'view redirect', url: noApiRoute('redirects.index'))
                ->addItem(title: trans('delta::menu.metatags'), permission: 'view metatag', url: noApiRoute('metatags.index'))
                ->addItem(title: trans('delta::menu.robots'), permission: 'view robots', url: noApiRoute('robots'))
                ->get()
            )
            ->addItem(title: trans('delta::menu.system'), name: 'system', icon: 'settings',
                items: BackendMenu::new($user)
                    ->addItem(title: trans('delta::menu.translations'), permission: 'view translation', url: noApiRoute('translations.show'))
                    ->addItem(title: trans('delta::menu.settings'), permission: 'view setting', url: noApiRoute('settings.index'))
                    ->get()
            )
            ->get();
    }
    private function url(string $title, string $route, string $permission)
    {
        return [
            'title' => $title,
            'url' => noApiRoute($route),
            'permission' => $permission
        ];
    }
}
