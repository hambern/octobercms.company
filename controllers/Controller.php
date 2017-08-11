<?php namespace Hambern\Company\Controllers;

use Backend\Classes\Controller as BaseController;

/**
 * Courses Back-end Controller
 */
class Controller extends BaseController
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = '../relations/config_relation.yaml';
}
