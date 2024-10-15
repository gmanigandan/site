<?php

namespace App\Livewire\Backend\Admin;

use Livewire\Component;
use App\Models\Backend\Admin;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin-dashboard')]
class Index extends Component
{
    use WithPagination;

    public $perPage = 50;
    public $search = '';
    public $delete_id = '';
    public $sortColumn = 'name';
    public $sortDirection = 'ASC';
    public $selectedIds = [];
    public $selectAll = false;

    protected $listeners = ['resetSelectedIds' => 'resetSelected'];

    public function mount()
    {
        $this->perPage = request()->query('perPage', $this->perPage);
    }

    public function resetSelected()
    {
        $this->selectedIds = [];
        $this->selectAll = false;
    }

    public function updatedSelectedIds()
    {
        $this->selectAll = count($this->selectedIds) === $this->perPage;
    }

    public function updatedSelectAll()
    {
        $this->selectedIds = $this->selectAll 
            ? Admin::search($this->search)->orderBy($this->sortColumn, $this->sortDirection)->pluck('id') 
            : [];
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function updatedPage()
    {
        $this->dispatch('paginationLoading'); // Emit event for pagination loading
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function doSort($column) 
    {
        $this->sortDirection = $this->sortColumn === $column 
            ? ($this->sortDirection === 'ASC' ? 'DESC' : 'ASC') 
            : 'ASC';

        $this->sortColumn = $column;
    }

    public function deleteModal($id) 
    {
        if ($id != '') {
            $this->delete_id = $id;
        }

        $this->dispatch('deleteConfirmationModal');
    }

    public function deleteRow() 
    {
        if ($this->delete_id != '') {
            Admin::findOrFail($this->delete_id)->delete();
            $this->delete_id = '';
        }

        if (count($this->selectedIds)) {
            Admin::whereIn('id', $this->selectedIds)->delete();
            $this->selectedIds = [];
        }

        session()->flash('success', 'Admin Deleted Successfully!');
        $this->dispatch('closeModal');
    }

    public function render()
    {
        $admins = Admin::search($this->search)
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.backend.admin.index', compact('admins'));
    }
}
