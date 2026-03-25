<?php

namespace App\Observers;

use App\Models\Employee;
use App\Services\CacheInvalidationService;

class EmployeeObserver
{
    public function created(Employee $employee): void
    {
        CacheInvalidationService::clearEmployeeCaches();
    }

    public function updated(Employee $employee): void
    {
        CacheInvalidationService::clearEmployeeCaches();
    }

    public function deleted(Employee $employee): void
    {
        CacheInvalidationService::clearEmployeeCaches();
    }

    public function restored(Employee $employee): void
    {
        CacheInvalidationService::clearEmployeeCaches();
    }
}
