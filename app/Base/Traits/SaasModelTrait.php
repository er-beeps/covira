<?php

namespace App\Base\Traits;


abstract class DataAccessPermission{
    const DeveloperOnly = 1;    //will be inserted/updated through migrateion
    const SystemOnly = 2;
    const ClientCRUDRestriction = 3;
    const SystemDataShareWithClient = 4;
    const ShowClientWiseDataOnly = 5;
    const DisableClientView = 6;
    const EnableEditButtonOnSystemData = 7;
    const DisplayClientDataToSystemUser = 8;
}


trait SaasModelTrait
{
    public $dataAccessPermission = DataAccessPermission::SystemDataShareWithClient;
    public $hasClientId = false;

    public function getFilterComboOptions(){
        $user = backpack_user();
        $client_id = $user->client_id;
        if(isset($client_id) == false){
            $client_id = 1;
        }
        switch ($this->dataAccessPermission) {
            case DataAccessPermission::DeveloperOnly :
            case DataAccessPermission::SystemOnly :
            case DataAccessPermission::ClientCRUDRestriction :
            case DataAccessPermission::EnableEditButtonOnSystemData:
                $a = self::selectRaw("code|| ' - ' || name_lc as name_lc , id");
                if($this->hasClientId)
                    $a->where('client_id', 1);

                return $a->orderBy('name_lc', 'ASC')
                    ->get()
                    ->keyBy('id')
                    ->pluck('name_lc', 'id')
                    ->toArray();
                break;
            case DataAccessPermission::SystemDataShareWithClient :
                $a = self::selectRaw("code|| ' - ' || name_lc as name_lc , id");
                if($this->hasClientId)
                    $a->whereIn('client_id', [1, $client_id]);

                return $a->orderBy('name_lc', 'ASC')
                    ->get()
                    ->keyBy('id')
                    ->pluck('name_lc', 'id')
                    ->toArray();
                break;
            case DataAccessPermission::DisableClientView :
            case DataAccessPermission::ShowClientWiseDataOnly :
                $a = self::selectRaw("code|| ' - ' || name_lc as name_lc , id");
                if($this->hasClientId)
                    $a->where('client_id', $client_id);

                return $a->orderBy('name_lc', 'ASC')
                    ->get()
                    ->keyBy('id')
                    ->pluck('name_lc', 'id')
                    ->toArray();
                break;
            default:
                # code...
                break;
        }
        return null;
        
    }
    // public function getFilterFiscalYear(){
    //     $a = self::selectRaw("code , id");
    //     if($this->hasClientId)
    //         $a->where('client_id', 1);

    //     return $a->orderBy('code', 'ASC')
    //         ->get()
    //         ->keyBy('id')
    //         ->pluck('code', 'id')
    //         ->toArray();
    // }



    public function getFieldComboOptions($query){
        $user = backpack_user();
        $client_id = $user->client_id;
        if(isset($client_id) == false){
            $client_id =1;
        }
        // var $obj = new self();
        switch ($this->dataAccessPermission) {
            case DataAccessPermission::DeveloperOnly :
            case DataAccessPermission::SystemOnly :
            case DataAccessPermission::ClientCRUDRestriction :
            case DataAccessPermission::EnableEditButtonOnSystemData:
                $query->selectRaw("code|| ' - ' || name_lc as name_lc, id");
                if($this->hasClientId)
                    $query->where('client_id', 1);

                return $query->orderBy('name_lc', 'ASC')
                    ->get();
                break;
            case DataAccessPermission::SystemDataShareWithClient :
                $query->selectRaw("code|| ' - ' || name_lc as name_lc, id");
                if($this->hasClientId)
                    $query->whereIn('client_id', [1, $client_id]);

                return $query->orderBy('name_lc', 'ASC')
                    ->get();
                break;
            case DataAccessPermission::DisableClientView : 
            case DataAccessPermission::ShowClientWiseDataOnly :
                $query->selectRaw("code|| ' - ' || name_lc as name_lc, id");
                if($this->hasClientId)
                    $query->where('client_id', $client_id);

                $a = $query->orderBy('name_lc', 'ASC')
                    ->get();
                return $a;
                break;
            default:
                # code...
                break;
        }
        return null;
    }
}