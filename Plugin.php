<?php namespace Hambern\Company;

use Backend;
use Backend\Facades\BackendAuth;
use System\Classes\PluginBase;

/**
 * Employees Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'hambern.company::lang.plugin.name',
            'description' => 'hambern.company::lang.plugin.description',
            'author' => 'Hambern',
            'icon' => 'icon-building',
        ];
    }

    public function registerNavigation()
    {
        return [
            'company' => [
                'label' => 'hambern.company::lang.plugin.name',
                'url' => Backend::url('hambern/company/' . $this->startPage()),
                'icon' => 'icon-building',
                'permissions' => ['hambern.company.*'],
                'order' => 500,
                'sideMenu' => [
                    'employees' => [
                        'label' => 'hambern.company::lang.employees.menu_label',
                        'icon' => 'icon-user',
                        'url' => Backend::url('hambern/company/employees'),
                        'permissions' => ['hambern.company.access_employees'],
                    ],
                    'roles' => [
                        'label' => 'hambern.company::lang.roles.menu_label',
                        'icon' => 'icon-briefcase',
                        'url' => Backend::url('hambern/company/roles'),
                        'permissions' => ['hambern.company.access_employees'],
                    ],
                    'projects' => [
                        'label' => 'hambern.company::lang.projects.menu_label',
                        'icon' => 'icon-wrench',
                        'url' => Backend::url('hambern/company/projects'),
                        'permissions' => ['hambern.company.access_projects'],
                    ],
                    'services' => [
                        'label' => 'hambern.company::lang.services.menu_label',
                        'icon' => 'icon-certificate',
                        'url' => Backend::url('hambern/company/services'),
                        'permissions' => ['hambern.company.access_services'],
                    ],
                    'galleries' => [
                        'label' => 'hambern.company::lang.galleries.menu_label',
                        'icon' => 'icon-photo',
                        'url' => Backend::url('hambern/company/galleries'),
                        'permissions' => ['hambern.company.access_galleries'],
                    ],
                    'testimonials' => [
                        'label' => 'hambern.company::lang.testimonials.menu_label',
                        'icon' => 'icon-comment',
                        'url' => Backend::url('hambern/company/testimonials'),
                        'permissions' => ['hambern.company.access_testimonials'],
                    ],
                    'links' => [
                        'label' => 'hambern.company::lang.links.menu_label',
                        'icon' => 'icon-link',
                        'url' => Backend::url('hambern/company/links'),
                        'permissions' => ['hambern.company.access_links'],
                    ],
                    'tags' => [
                        'label' => 'hambern.company::lang.tags.menu_label',
                        'icon' => 'icon-tag',
                        'url' => Backend::url('hambern/company/tags'),
                        'permissions' => ['hambern.company.access_tags'],
                    ],
                ],
            ],
        ];
    }

    public function startPage($page = 'projects')
    {
        $user = BackendAuth::getUser();
        $permissions = array_reverse(array_keys($this->registerPermissions()));
        if (!isset($user->permissions['superuser']) && $user->hasAccess('hambern.company.*')) {
            foreach ($permissions as $access) {
                if ($user->hasAccess($access)) {
                    $page = explode('_', $access)[1];
                }
            }
        }
        return $page;
    }

    public function registerPermissions()
    {
        return [
            'hambern.company.access_employees' => [
                'label' => 'hambern.company::lang.employee.list_title',
                'tab' => 'hambern.company::lang.plugin.name',
            ],
            'hambern.company.access_projects' => [
                'label' => 'hambern.company::lang.project.list_title',
                'tab' => 'hambern.company::lang.plugin.name',
            ],
            'hambern.company.access_services' => [
                'label' => 'hambern.company::lang.service.list_title',
                'tab' => 'hambern.company::lang.plugin.name',
            ],
            'hambern.company.access_galleries' => [
                'label' => 'hambern.company::lang.gallery.list_title',
                'tab' => 'hambern.company::lang.plugin.name',
            ],
            'hambern.company.access_links' => [
                'label' => 'hambern.company::lang.link.list_title',
                'tab' => 'hambern.company::lang.plugin.name',
            ],
            'hambern.company.access_testimonials' => [
                'label' => 'hambern.company::lang.testimonial.list_title',
                'tab' => 'hambern.company::lang.plugin.name',
            ],
            'hambern.company.access_tags' => [
                'label' => 'hambern.company::lang.tag.list_title',
                'tab' => 'hambern.company::lang.plugin.name',
            ],
            'hambern.company.access_company' => [
                'label' => 'hambern.company::lang.company.list_title',
                'tab' => 'hambern.company::lang.plugin.name',
            ],
        ];
    }

    public function registerComponents()
    {
        return [
            'Hambern\Company\Components\Employees' => 'Employees',
            'Hambern\Company\Components\Roles' => 'Roles',
            'Hambern\Company\Components\Projects' => 'Projects',
            'Hambern\Company\Components\Services' => 'Services',
            'Hambern\Company\Components\Galleries' => 'Galleries',
            'Hambern\Company\Components\Company' => 'Company',
            'Hambern\Company\Components\Testimonials' => 'Testimonials',
            'Hambern\Company\Components\Links' => 'Links',
            'Hambern\Company\Components\Tags' => 'Tags',
        ];
    }

    public function registerSettings()
    {
        return [
            'company' => [
                'label' => 'hambern.company::lang.plugin.name',
                'description' => 'hambern.company::lang.settings.description',
                'category' => 'system::lang.system.categories.system',
                'icon' => 'icon-building-o',
                'class' => 'Hambern\Company\Models\Company',
                'order' => 500,
                'keywords' => 'hambern.company::lang.settings.label',
                'permissions' => ['hambern.company.access_company'],
            ],
        ];
    }

    public function register()
    {
        set_exception_handler([$this, 'handleException']);
    }

    public function handleException($e)
    {
        if (!$e instanceof Exception) {
            $e = new \Symfony\Component\Debug\Exception\FatalThrowableError($e);
        }
        $handler = $this->app->make('Illuminate\Contracts\Debug\ExceptionHandler');
        $handler->report($e);
        if ($this->app->runningInConsole()) {
            $handler->renderForConsole(new ConsoleOutput, $e);
        } else {
            $handler->render($this->app['request'], $e)->send();
        }
    }
}
