<?php
namespace App\Base\Crud;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanel as Panel;
use App\Base\Crud\Traits\SaveActions;
use App\Base\Crud\Traits\Search;

class CrudPanel extends Panel
{
    use SaveActions, Search;
    
}
