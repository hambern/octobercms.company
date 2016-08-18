<?php namespace Hambern\Company\Components;

use Hambern\Company\Models\Gallery;

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

	public function gallery()
	{
		if (is_numeric($this->property('itemId'))) {
			if ($this->item) return $this->item;
			return $this->item = Gallery::whereId($this->property('itemId'))->with('pictures')->first();
		}
	}

	public function galleries()
	{
		if (!is_numeric($this->property('itemId'))) {
			if ($this->list) return $this->list;
			$galleries = Gallery::published()
				->with('pictures')
				->orderBy($this->property('orderBy', 'id'), $this->property('sort', 'desc'))
				->take($this->property('maxItems'));

			return $this->list = $this->property('paginate') ?
				$galleries->paginate($this->property('perPage'), $this->property('page')) :
				$galleries->get();
		}
	}
}
