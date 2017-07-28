<?php namespace Hambern\Company\Components;

use Cms\Classes\ComponentBase;
use Hambern\Company\Models\Company as Settings;
use Hambern\Company\Models\Employee;
use October\Rain\Database\Model;

class Company extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name' => 'hambern.company::lang.components.company.name',
            'description' => 'hambern.company::lang.components.company.description',
        ];
    }

    public function defineProperties()
    {
        return [];
    }

    public function onRun()
    {
        $settings = Settings::instance();
        $company = new Model();
        $company->name = $settings->name;
        $company->slogan = $settings->slogan;
        $company->logo = $settings->logo;
        $company->story = $settings->story;
        $company->phone = $settings->phone;
        $company->fax = $settings->fax;
        $company->email = $settings->email;
        $company->address = $settings->address;
        $company->social_media = $settings->social_media;
        $company->contact = $this->contact();
        $company->street_name = $settings->street_name;
        $company->street_number = $settings->street_number;
        $company->zip = $settings->zip;
        $company->city = $settings->city;
        $this->page['company'] = $company;
    }

    public function contact()
    {
        if ($employee = Employee::find(Settings::get('contact'))) {
            return $employee;
        }
        return Employee::orderBy('id', 'asc')->first();
    }

}
