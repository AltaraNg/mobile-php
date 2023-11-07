<?php

namespace App\Repositories\Eloquent\Repository;

use App\Models\CustomerMobileAppAudit;

class CustomerMobileAppAuditRepository extends BaseRepository
{
    public function __construct(CustomerMobileAppAudit $model)
    {
        parent::__construct($model);
    }

    public function query()
    {
        return $this->model->query();
    }
}
