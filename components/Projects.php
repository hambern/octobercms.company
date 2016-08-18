<?php namespace Hambern\Company\Components;

use Hambern\Company\Models\Project;

class Projects extends Component
{

	public $table = 'hambern_company_projects';

	public function componentDetails()
	{
		return [
			'name'        => 'hambern.company::lang.components.projects.name',
			'description' => 'hambern.company::lang.components.projects.description',
		];
	}

	public function onRun()
	{
			$this->page['project'] = $this->project();
			$this->page['projects'] = $this->projects();
	}

	public function project()
  {
    if (is_numeric($this->property('itemId'))) {
			if ($this->item) return $this->item;
			return $this->item = Project::whereId($this->property('itemId'))->with('picture', 'pictures', 'files')->first();
    }
  }

  public function projects()
  {
    if (!is_numeric($this->property('itemId'))) {
			if ($this->list) return $this->list;
      $projects = Project::published()
				->with('picture', 'pictures', 'files')
				->orderBy($this->property('orderBy', 'id'), $this->property('sort', 'desc'))
				->take($this->property('maxItems'));

      return $this->property('paginate') ?
        $projects->paginate($this->property('perPage'), $this->property('page')) :
        $projects->get();
    }
  }
}
