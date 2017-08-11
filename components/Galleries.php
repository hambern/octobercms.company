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
            'name' => 'hambern.company::lang.components.galleries.name',
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
        if (!empty($this->property('itemId'))) {
            if ($this->item) return $this->item;
            return $this->item = Gallery::where($this->property('modelIdentifier', 'id'), $this->property('itemId'))
                ->with('pictures')
                ->first();
        }
    }

    public function galleries()
    {
        if (empty($this->property('itemId'))) {
            if ($this->list) return $this->list;

            $galleries = Gallery::published()->with('pictures');

            if ($this->property('filterTag')) {
                $id_attribute = $this->property('tagIdentifier', 'id');
                $galleries->whereHas('tags', function ($query) use ($id_attribute) {
                    $query->where($id_attribute, '=', $this->property('filterTag'));
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

    public function defineProperties()
    {
        $properties = parent::defineProperties();
        $properties['tagIdentifier'] = [
            'title' => 'hambern.company::lang.tags.tag_identifier',
            'description' => 'hambern.company::lang.descriptions.tag_identifier',
            'type' => 'dropdown',
            'options' => ['id' => 'id', 'slug' => 'slug'],
            'default' => 'id',
            'group' => 'hambern.company::lang.labels.filters',
        ];
        $properties['filterTag'] = [
            'title' => 'hambern.company::lang.tags.menu_label',
            'description' => 'hambern.company::lang.descriptions.filter_tags',
            'type' => 'dropdown',
            'group' => 'hambern.company::lang.labels.filters',
        ];
        return $properties;
    }

    public function getFilterTagOptions()
    {
        $options = [Lang::get('hambern.company::lang.labels.show_all')];
        $tags = Tag::has('galleries')->get();
        $id_attribute = $this->property('tagIdentifier', 'id');
        $options += $tags->lists('name', $id_attribute);

        return $options;
    }
}
