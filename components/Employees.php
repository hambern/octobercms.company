<?php namespace Hambern\Company\Components;

use Hambern\Company\Models\Employee;

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

	public function employee()
	{
		if (is_numeric($this->property('itemId'))) {
			if ($this->item) return $this->item;
			return $this->item = Employee::whereId($this->property('itemId'))->with('picture')->first();
		}
	}

	public function employees()
	{
		if (!is_numeric($this->property('itemId'))) {
			if ($this->list) return $this->list;
			$employees = Employee::published()
				->with('picture')
				->orderBy($this->property('orderBy', 'id'), $this->property('sort', 'desc'))
				->take($this->property('maxItems'));

			return $this->list = $this->property('paginate') ?
					$employees->paginate($this->property('perPage'), $this->property('page')) :
					$employees->get();
		}
	}
}
