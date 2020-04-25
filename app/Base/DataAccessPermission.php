<?php
namespace App\Base;

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