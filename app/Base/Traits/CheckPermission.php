<?php
namespace App\Base\Traits;

use App\Base\DataAccessPermission;



/**
 *  CheckPermission
 */
trait CheckPermission
{
    private $dataPermission;
    private $user;
    private $hasUserId;

    protected $permissions = ['list', 'create', 'update', 'delete', 'export', 'print'];
    protected $overRide = [];

    public function checkPermission($overRide =  [])
    {
        $this->overRide = $overRide;
        $this->dataPermission =  property_exists($this->crud->model, 'dataAccessPermission') ? $this->crud->model->dataAccessPermission : DataAccessPermission::SystemOnly;
        $this->user = backpack_user();
        $this->hasUserId = property_exists($this->crud->model, 'user_id');
        $this->hasUserId = in_array('user_id', $this->crud->model->getFillable());
        if ($this->hasUserId) {
            $this->filterByUser();
        }
        $this->crud->denyAccess(['list', 'create', 'update', 'delete', 'export', 'print']);
        $this->filterPermission();
    }


    private function filterByUser()
    {
        if (backpack_user()->hasrole('normal')) {
            $this->crud->addClause('where', 'user_id', backpack_user()->id); 
        }
    }


    public function filterPermission()
    {
        $data = [];
        switch($this->dataPermission) {
            case DataAccessPermission::SystemOnly:
                $data = $this->systemOnly();
            break;
            case DataAccessPermission::ShowClientWiseDataOnly:
                $data = $this->showClientWiseDataOnly();
            break;
       
        }
        $access = [];

        if (!empty($this->overRide)) {
            foreach ($this->overRide as $key => $value) {
                $data[$key] = $value;
            }
        }
        
        foreach (backpack_user()->getRoleNames() as $role) {
            $access = array_unique(array_merge($access, $data[$role])); 
        }

        $this->crud->allowAccess($access);
    }

    public function systemOnly()
    {
        return [
            'superadmin' => ['list', 'create', 'update', 'delete', 'export', 'print'],
            'admin' => ['list', 'create', 'update', 'delete', 'export', 'print'],
            'normal' => ['list', 'export', 'print'],
        ];  
    }

    public function showClientWiseDataOnly()
    {
        return [
            'superadmin' => ['list', 'create', 'update', 'delete', 'export', 'print'],
            'admin' => ['create','list', 'export', 'print','update','delete'],
            'normal' => ['create','list', 'export', 'print','update','delete'],
        ];           
    }    
}
