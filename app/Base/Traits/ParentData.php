<?php
namespace App\Base\Traits;


/**
 * 
 */
trait ParentData
{

    protected $enableDialog = false;

    public function parent($name)
    {
        $request = $this->crud->request;
        return $request->route($name) ?? null;
    }

    public function setUpLink($methods = ['index'])
    {
        $currentMethod = $this->crud->getActionMethod();
        $exits = method_exists($this, 'tabLinks');
        if ($exits && in_array($currentMethod, $methods)) {
            $this->data['tab_links'] = $this->tabLinks();
        }
    }

    public function enableDialog($enable = true)
    {
        $this->data['controller'] = (new \ReflectionClass($this))->getShortName();
        $this->crud->controller = $this->data['controller'];
        $this->enableDialog = $enable;
        $this->data['enableDialog'] = property_exists($this, 'enableDialog') ? $this->enableDialog : false;
        $this->crud->enableDialog = property_exists($this, 'enableDialog') ? $this->enableDialog : false;
    }
    

}
