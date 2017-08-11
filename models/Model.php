<?php namespace Hambern\Company\Models;

use October\Rain\Database\Model as BaseModel;

class Model extends BaseModel
{

    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    public $translatable = ['name', 'description', 'content', 'information', 'quote', 'story', 'slogan'];

    protected $dates = ['published_at'];

    protected $guarded = ['*'];

    public function scopePublished($query)
    {
        return $query->where('published_at', '<', date('Y-m-d H:i:s'));
    }

    public function afterDelete()
    {
        if (!empty($this->picture)) {
            $this->picture->delete();
        }
        if (!empty($this->pictures)) {
            foreach ($this->pictures as $item) {
                $item->delete();
            }
        }
        if (!empty($this->files)) {
            foreach ($this->files as $item) {
                $item->delete();
            }
        }
    }
}
