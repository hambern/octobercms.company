<?php namespace Hambern\Company\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Schema;
use Hambern\Company\Models\Tag;
use Hambern\Company\Models\Role;

class Component extends ComponentBase
{

    public $item;
    public $list;
    public $table;

    public function componentDetails()
    {
    }

    public function defineProperties()
    {
        return [
            'itemId' => [
                'title' => 'hambern.company::lang.labels.item_id',
                'description' => 'hambern.company::lang.descriptions.item_id',
                'default' => '{{ :model }}',
            ],
            'modelIdentifier' => [
                'title' => 'hambern.company::lang.misc.model_identifier',
                'description' => 'hambern.company::lang.descriptions.model_identifier',
                'type' => 'dropdown',
                'options' => ['id' => 'id', 'slug' => 'slug'],
                'default' => 'id',
            ],
            'maxItems' => [
                'title' => 'hambern.company::lang.labels.max_items',
                'description' => 'hambern.company::lang.descriptions.max_items',
                'default' => 36,
                'type' => 'string',
                'validationPattern' => '^[0-9]+$',
            ],
            'orderBy' => [
                'title' => 'hambern.company::lang.labels.order_by',
                'description' => 'hambern.company::lang.descriptions.order_by',
                'type' => 'dropdown',
                'default' => 'id',
                'group' => 'hambern.company::lang.labels.order',
            ],
            'sort' => [
                'title' => 'hambern.company::lang.labels.sort',
                'description' => 'hambern.company::lang.descriptions.sort',
                'type' => 'dropdown',
                'default' => 'desc',
                'group' => 'hambern.company::lang.labels.order',
            ],
            'paginate' => [
                'title' => 'hambern.company::lang.labels.paginate',
                'description' => 'hambern.company::lang.descriptions.paginate',
                'type' => 'checkbox',
                'default' => false,
                'group' => 'hambern.company::lang.labels.paginate',
            ],
            'page' => [
                'title' => 'hambern.company::lang.labels.page',
                'description' => 'hambern.company::lang.descriptions.page',
                'type' => 'string',
                'default' => '1',
                'validationPattern' => '^[0-9]+$',
                'group' => 'hambern.company::lang.labels.paginate',
            ],
            'perPage' => [
                'title' => 'hambern.company::lang.labels.per_page',
                'description' => 'hambern.company::lang.descriptions.per_page',
                'type' => 'string',
                'default' => '12',
                'validationPattern' => '^[0-9]+$',
                'group' => 'hambern.company::lang.labels.paginate',
            ],
        ];
    }

    public function getSortOptions()
    {
        return [
            'desc' => Lang::get('hambern.company::lang.labels.descending'),
            'asc' => Lang::get('hambern.company::lang.labels.ascending'),
        ];
    }

    public function getOrderByOptions()
    {
        $schema = Schema::getColumnListing($this->table);
        foreach ($schema as $column) {
            $options[$column] = ucwords(str_replace('_', ' ', $column));
        }
        return $options;
    }

}
