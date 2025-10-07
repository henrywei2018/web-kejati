<?php

namespace App\Livewire\Pages;

use App\Models\Employee;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeListPage extends Component
{
    use WithPagination;

    public $search = '';
    public $department = '';
    public $employmentStatus = '';
    public $sortBy = 'display_order';
    public $sortDirection = 'asc';

    public $selectedEmployee = null;
    public $showModal = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'department' => ['except' => ''],
        'employmentStatus' => ['except' => ''],
        'sortBy' => ['except' => 'display_order'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingDepartment()
    {
        $this->resetPage();
    }

    public function updatingEmploymentStatus()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function showDetail($employeeId)
    {
        $this->selectedEmployee = Employee::with('media')->find($employeeId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedEmployee = null;
    }

    public function render()
    {
        $employees = Employee::query()
            ->active()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('nip', 'like', '%' . $this->search . '%')
                      ->orWhere('position', 'like', '%' . $this->search . '%')
                      ->orWhere('rank', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->department, function ($query) {
                $query->where('department', $this->department);
            })
            ->when($this->employmentStatus, function ($query) {
                $query->where('employment_status', $this->employmentStatus);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(12);

        $departments = Employee::active()
            ->whereNotNull('department')
            ->distinct()
            ->pluck('department')
            ->sort();

        $employmentStatuses = ['PNS', 'PPPK', 'Honorer', 'Kontrak'];

        // Statistics
        $totalEmployees = Employee::active()->count();
        $totalPNS = Employee::active()->where('employment_status', 'PNS')->count();
        $totalPPPK = Employee::active()->where('employment_status', 'PPPK')->count();

        return view('livewire.pages.employee-list-page', [
            'employees' => $employees,
            'departments' => $departments,
            'employmentStatuses' => $employmentStatuses,
            'totalEmployees' => $totalEmployees,
            'totalPNS' => $totalPNS,
            'totalPPPK' => $totalPPPK,
        ])->layout('layouts.main', [
            'title' => 'Daftar Pegawai - Kejaksaan Tinggi Kalimantan Utara',
            'metaDescription' => 'Daftar pegawai Kejaksaan Tinggi Kalimantan Utara',
            'metaKeywords' => 'pegawai, sdm, kejaksaan tinggi kaltara'
        ]);
    }
}
