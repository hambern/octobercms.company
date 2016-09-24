<?php namespace Hambern\Company\Components;

use Hambern\Company\Models\Employee;
use Illuminate\Support\Facades\Lang;
use Hambern\Company\Models\Role;

class Employees extends Component
{
	public $table = 'hambern_company_employees';

	public function componentDetails()
	{
		return [
			'name'        => 'hambern.company::lang.components.employees.name',
			'description' => 'hambern.company::lang.components.employees.description',
		];
	}

	public function onRun()
	{
			$this->page['employee'] = $this->employee();
			$this->page['employees'] = $this->employees();
	}

	public function defineProperties()
	{
		$properties = parent::defineProperties();
		$properties['filterRole'] = [
			'title'       => 'hambern.company::lang.roles.menu_label',
			'description' => 'hambern.company::lang.descriptions.filter_roles',
			'type'        => 'dropdown',
			'group'     	=> 'hambern.company::lang.labels.filters',
		];
		return $properties;
	}

	public function employee()
	{
		if (is_numeric($this->property('itemId')) && !empty($this->property('itemId'))) {
			if ($this->item) return $this->item;
			return $this->item = Employee::whereId($this->property('itemId'))->with('picture')->first();
		}
	}

	public function employees()
  {
    if (!is_numeric($this->property('itemId')) || empty($this->property('itemId'))) {
			if ($this->list) return $this->list;

			$employees = Employee::published()->with('picture');

			if ($this->property('filterRole')) {
				$employees->whereHas('roles', function ($query) {
	    		$query->where('id', '=', $this->property('filterRole'));
				})->with('roles');
			}

      $employees = $employees->orderBy(
				$this->property('orderBy', 'id'),
				$this->property('sort', 'desc'))->take($this->property('maxItems'));

			return $this->list = $this->property('paginate') ?
        $employees->paginate($this->property('perPage'), $this->property('page')) :
        $employees->get();
    }
  }

	public function getFilterRoleOptions()
	{
		$options = [Lang::get('hambern.company::lang.labels.show_all')];
		$roles = Role::has('employees')->get();
		if ($roles)
			$options += $roles->lists('name', 'id');
		return $options;
	}
}
