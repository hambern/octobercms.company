<?php namespace Hambern\Company\Models;

/**
 * Project Model
 */
class Project extends Model
{

	/**
	 * @var string The database table used by the model.
	 */
	public $table = 'hambern_company_projects';
	/**
	 * @var array Relations
	 */
	public $hasOne = [];
	public $hasMany = [];
	public $belongsTo = [];
	public $belongsToMany = [
		'services' => [
			'Hambern\Company\Models\Service',
			'table' => 'hambern_company_pivots',
		],
		'tags' => [
			'Hambern\Company\Models\Tag',
			'table' => 'hambern_company_pivots',
		],
	];
	public $morphTo = [];
	public $morphOne = [];
	public $morphMany = [];
	public $attachOne = [
		'picture' => ['System\Models\File'],
	];
	public $attachMany = [
		'pictures' => ['System\Models\File'],
		'files'    => ['System\Models\File'],
	];

	public function afterDelete()
	{
		parent::afterDelete();
		$this->services()->detach();
	}

}
