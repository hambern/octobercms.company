<?php namespace Hambern\Company\Components;

use Hambern\Company\Models\Project;
use Illuminate\Support\Facades\Lang;
use Hambern\Company\Models\Tag;

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

	public function defineProperties()
	{
		$properties = parent::defineProperties();
		$properties['filterTag'] = [
			'title'       => 'hambern.company::lang.tags.menu_label',
			'description' => 'hambern.company::lang.descriptions.filter_tags',
			'type'        => 'dropdown',
			'group'     	=> 'hambern.company::lang.labels.filters',
		];
		return $properties;
	}

	public function project()
  {
    if (is_numeric($this->property('itemId')) && !empty($this->property('itemId'))) {
			if ($this->item) return $this->item;
			return $this->item = Project::whereId($this->property('itemId'))->with('picture', 'pictures', 'files')->first();
    }
  }

	public function projects()
  {
    if (!is_numeric($this->property('itemId')) || empty($this->property('itemId'))) {
			if ($this->list) return $this->list;

			$projects = Project::published()->with('picture', 'pictures', 'files');

			if ($this->property('filterTag')) {
				$projects->whereHas('tags', function ($query) {
	    		$query->where('id', '=', $this->property('filterTag'));
				})->with('tags');
			}

      $projects = $projects->orderBy(
				$this->property('orderBy', 'id'),
				$this->property('sort', 'desc'))->take($this->property('maxItems'));

			return $this->list = $this->property('paginate') ?
        $projects->paginate($this->property('perPage'), $this->property('page')) :
        $projects->get();
    }
  }

	public function getFilterTagOptions()
	{
		$options = [Lang::get('hambern.company::lang.labels.show_all')];
		$tags = Tag::has('projects')->get();
		if ($tags)
			$options += $tags->lists('name', 'id');
		return $options;
	}
}
