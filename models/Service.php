<?php namespace Hambern\Company\Models;

/**
 * Service Model
 */
class Service extends Model
{

	/**
	 * @var string The database table used by the model.
	 */
	public $table = 'hambern_company_services';
	/**
	 * @var array Relations
	 */
	public $hasOne = [];
	public $hasMany = [];
	public $belongsTo = [];
	public $belongsToMany = [
		'projects' => [
			'Hambern\Company\Models\Project',
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
		$this->projects()->detach();
	}

}
