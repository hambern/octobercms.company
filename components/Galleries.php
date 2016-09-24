<?php namespace Hambern\Company\Components;

use Hambern\Company\Models\Gallery;
use Illuminate\Support\Facades\Lang;
use Hambern\Company\Models\Tag;

class Galleries extends Component
{

	public $table = 'hambern_company_galleries';

	public function componentDetails()
	{
		return [
			'name'        => 'hambern.company::lang.components.galleries.name',
			'description' => 'hambern.company::lang.components.galleries.description',
		];
	}

	public function onRun()
	{
			$this->page['gallery'] = $this->gallery();
			$this->page['galleries'] = $this->galleries();
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

	public function gallery()
	{
		if (is_numeric($this->property('itemId')) && !empty($this->property('itemId'))) {
			if ($this->item) return $this->item;
			return $this->item = Gallery::whereId($this->property('itemId'))->with('pictures')->first();
		}
	}

	public function galleries()
  {
    if (!is_numeric($this->property('itemId')) || empty($this->property('itemId'))) {
			if ($this->list) return $this->list;

			$galleries = Gallery::published()->with('pictures');

			if ($this->property('filterTag')) {
				$galleries->whereHas('tags', function ($query) {
	    		$query->where('id', '=', $this->property('filterTag'));
				})->with('tags');
			}

      $galleries = $galleries->orderBy(
				$this->property('orderBy', 'id'),
				$this->property('sort', 'desc'))->take($this->property('maxItems'));

			return $this->list = $this->property('paginate') ?
        $galleries->paginate($this->property('perPage'), $this->property('page')) :
        $galleries->get();
    }
  }

	public function getFilterTagOptions()
	{
		$options = [Lang::get('hambern.company::lang.labels.show_all')];
		$tags = Tag::has('galleries')->get();
		if ($tags)
			$options += $tags->lists('name', 'id');
		return $options;
	}
}
