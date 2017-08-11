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
            'name' => 'hambern.company::lang.components.projects.name',
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
        if (!empty($this->property('itemId'))) {
            if ($this->item) return $this->item;
            return $this->item = Project::where($this->property('modelIdentifier', 'id'), $this->property('itemId'))
                ->with('picture', 'pictures', 'files')
                ->first();
        }
    }

    public function projects()
    {
        if (empty($this->property('itemId'))) {
            if ($this->list) return $this->list;

            $projects = Project::published()->with('picture', 'pictures', 'files');

            if ($this->property('filterTag')) {
                $id_attribute = $this->property('tagIdentifier', 'id');
                $projects->whereHas('tags', function ($query) use ($id_attribute) {
                    $query->where($id_attribute, '=', $this->property('filterTag'));
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
            'depends' => ['tagIdentifier'],
            'group' => 'hambern.company::lang.labels.filters',
        ];
        return $properties;
    }

    public function getFilterTagOptions()
    {
        $options = [Lang::get('hambern.company::lang.labels.show_all')];
        $tags = Tag::has('projects')->get();
        $id_attribute = $this->property('tagIdentifier', 'id');
        $options += $tags->lists('name', $id_attribute);

        return $options;
    }
}
