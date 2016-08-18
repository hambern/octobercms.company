<?php namespace Hambern\Company\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Flash;
use Hambern\Company\Models\Project;
use Lang;

/**
 * Projects Back-end Controller
 */
class Projects extends Controller
{

	public $requiredPermissions = ['hambern.company.access_projects'];

	public $implement = [
		'Backend.Behaviors.FormController',
		'Backend.Behaviors.ListController',
	];

	public $formConfig = 'config_form.yaml';
	public $listConfig = 'config_list.yaml';

	public function __construct()
	{
		parent::__construct();

		BackendMenu::setContext('Hambern.Company', 'company', 'projects');
	}

	/**
	 * Deleted checked projects.
	 */
	public function index_onDelete()
	{
		if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

			foreach ($checkedIds as $projectId) {
				if (!$project = Project::find($projectId)) {
					continue;
				}

				$project->delete();
			}

			Flash::success(Lang::get('hambern.company::lang.projects.delete_selected_success'));
		} else {
			Flash::error(Lang::get('hambern.company::lang.projects.delete_selected_empty'));
		}

		return $this->listRefresh();
	}
}
