<?php namespace Hambern\Company\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Flash;
use Hambern\Company\Models\Role;
use Lang;

/**
 * Roles Back-end Controller
 */
class Roles extends Controller
{

	public $requiredPermissions = ['hambern.company.access_employees'];

	public $implement = [
		'Backend.Behaviors.FormController',
		'Backend.Behaviors.ListController',
	];

	public $formConfig = 'config_form.yaml';
	public $listConfig = 'config_list.yaml';

	public function __construct()
	{
		parent::__construct();

		BackendMenu::setContext('Hambern.Company', 'company', 'roles');
	}

	/**
	 * Deleted checked roles.
	 */
	public function index_onDelete()
	{
		if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

			foreach ($checkedIds as $roleId) {
				if (!$role = Role::find($roleId)) {
					continue;
				}

				$role->delete();
			}

			Flash::success(Lang::get('hambern.company::lang.roles.delete_selected_success'));
		} else {
			Flash::error(Lang::get('hambern.company::lang.roles.delete_selected_empty'));
		}

		return $this->listRefresh();
	}
}
