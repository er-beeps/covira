<?php
namespace App\Base;

use App\Base\Traits\SaasModelTrait;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class BaseModel extends  Model
{
    use CrudTrait;
    use SaasModelTrait;


    public function setGuarded($guarded=["id"]){

        $this->guarded = $guarded;
    }
}
