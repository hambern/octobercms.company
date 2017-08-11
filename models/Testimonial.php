<?php namespace Hambern\Company\Models;

/**
 * Testimonial Model
 */
class Testimonial extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'hambern_company_testimonials';
    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [
        'picture' => ['System\Models\File'],
    ];
    public $attachMany = [];

}
