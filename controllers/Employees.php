<?php namespace Hambern\Company\Controllers;

use BackendMenu;
use Flash;
use Hambern\Company\Models\Employee;
use Lang;

/**
 * Employees Back-end Controller
 */
class Employees extends Controller
{

    public $requiredPermissions = ['hambern.company.access_employees'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Hambern.Company', 'company', 'employees');
    }

    /**
     * Deleted checked employees.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $employeeId) {
                if (!$employee = Employee::find($employeeId)) {
                    continue;
                }

                $employee->delete();
            }

            Flash::success(Lang::get('hambern.company::lang.employees.delete_selected_success'));
        } else {
            Flash::error(Lang::get('hambern.company::lang.employees.delete_selected_empty'));
        }

        return $this->listRefresh();
    }
}
