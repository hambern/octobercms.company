<?php namespace Hambern\Company\Components;

use Hambern\Company\Models\Service;

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

	public function service()
  {
    if (is_numeric($this->property('itemId'))) {
			if ($this->item) return $this->item;
			return $this->item = Service::whereId($this->property('itemId'))->with('picture', 'pictures', 'files')->first();
    }
  }

  public function services()
  {
    if (!is_numeric($this->property('itemId'))) {
			if ($this->list) return $this->list;
      $services = Service::published()
				->with('picture', 'pictures', 'files')
				->orderBy($this->property('orderBy', 'id'), $this->property('sort', 'desc'))
				->take($this->property('maxItems'));

			return $this->list = $this->property('paginate') ?
        $services->paginate($this->property('perPage'), $this->property('page')) :
        $services->get();
    }
  }
}
