<?php
namespace App\Base;

use App\Base\Traits\SaasModelTrait;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends  Model
{
    use SaasModelTrait;
    public function setGuarded($guarded=["id"]){

        $this->guarded = $guarded;
    }
}
