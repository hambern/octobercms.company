<?php namespace Hambern\Company\Components;

use Hambern\Company\Models\Service;
use Illuminate\Support\Facades\Lang;
use Hambern\Company\Models\Tag;

class Services extends Component
{

	public $table = 'hambern_company_services';

	public function componentDetails()
	{
		return [
			'name'        => 'hambern.company::lang.components.services.name',
			'description' => 'hambern.company::lang.components.services.description',
		];
	}

	public function onRun()
	{
			$this->page['service'] = $this->service();
			$this->page['services'] = $this->services();
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

	public function service()
  {
    if (is_numeric($this->property('itemId')) && !empty($this->property('itemId'))) {
			if ($this->item) return $this->item;
			return $this->item = Service::whereId($this->property('itemId'))->with('picture', 'pictures', 'files')->first();
    }
  }

  public function services()
  {
    if (!is_numeric($this->property('itemId')) || empty($this->property('itemId'))) {
			if ($this->list) return $this->list;

			$services = Service::published()->with('picture', 'pictures', 'files');

			if ($this->property('filterTag')) {
				$services->whereHas('tags', function ($query) {
	    		$query->where('id', '=', $this->property('filterTag'));
				})->with('tags');
			}

      $services = $services->orderBy(
				$this->property('orderBy', 'id'),
				$this->property('sort', 'desc'))->take($this->property('maxItems'));

			return $this->list = $this->property('paginate') ?
        $services->paginate($this->property('perPage'), $this->property('page')) :
        $services->get();
    }
  }

	public function getFilterTagOptions()
	{
		$options = [Lang::get('hambern.company::lang.labels.show_all')];
		$tags = Tag::has('services')->get();
		if ($tags)
			$options += $tags->lists('name', 'id');
		return $options;
	}
}
