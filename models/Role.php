<?php namespace Hambern\Company\Models;

/**
 * Role Model
 */
class Role extends Model
{
    use \October\Rain\Database\Traits\Sluggable;

    /**
     * @var array Generate slugs for these attributes.
     */
    protected $slugs = ['slug' => 'name'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'hambern_company_roles';
    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [
        'employees' => [
            'Hambern\Company\Models\Employee',
            'table' => 'hambern_company_pivots',
        ],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public function afterDelete()
    {
        parent::afterDelete();
        $this->employees()->detach();
    }

    public function getEmployeesOptions()
    {
        $options = [];
        $employees = Employee::orderBy('last_name', 'asc')->orderBy('first_name', 'asc')->get();
        foreach ($employees as $employee) {
            $options[$employee->id] = $employee->name;
        }
        return $options;
    }

}
