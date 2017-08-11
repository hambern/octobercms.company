<?php namespace Hambern\Company\Components;

use Hambern\Company\Models\Link;

class Links extends Component
{

    public $table = 'hambern_company_links';

    public function componentDetails()
    {
        return [
            'name' => 'hambern.company::lang.components.links.name',
            'description' => 'hambern.company::lang.components.links.description'
        ];
    }

    public function onRun()
    {
        $this->page['link'] = $this->link();
        $this->page['links'] = $this->links();
    }

    public function link()
    {
        if (!empty($this->property('itemId'))) {
            if ($this->item) return $this->item;
            return $this->item = Link::where($this->property('modelIdentifier', 'id'), $this->property('itemId'))
                ->with('picture', 'pictures')
                ->first();
        }
    }

    public function links()
    {
        if (empty($this->property('itemId'))) {
            if ($this->list) return $this->list;
            $links = Link::published()
                ->with('picture', 'pictures')
                ->orderBy($this->property('orderBy', 'id'), $this->property('sort', 'desc'))
                ->take($this->property('maxItems'));

            return $this->list = $this->property('paginate') ?
                $links->paginate($this->property('perPage'), $this->property('page')) :
                $links->get();
        }
    }
}
