<?php

namespace App\Livewire\Backend\Roles;

use Livewire\Component;
use App\Models\Backend\Permissions;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
#[Layout('components.layouts.admin-dashboard')] 
class AllPermissions extends Component
{
    use WithPagination;
    public $perPage = 50;
    public $search = '';
    public $delete_id = '';
    public $edit_id = null;
    public $sortColumn = 'name';
    public $sortDirection = 'ASC';
    public $selectedIds = [];
    public $modules = [
        'admins' => 'Admin Users',
        'roles-permissions' => 'Roles & Permissions',
        'settings' => 'Settings',
        'users' => 'Users',
        'masterdata' => 'Master Data',
    ];
    public $selectAll = false;
    public $listeners = ['resetSelectedIds' => 'resetSelected'];
    public $name, $group_name;


    public function mount()
    {
        $this->perPage = request()->query('perPage', $this->perPage);
        $this->dispatch('livewire:updated');
    }
    public function updated()
    {
        $this->dispatch('livewire:updated');
    }
    public function showAddPermissionModal()
    {
        // Clear any existing form data
        $this->reset();
        $this->clearValidation();
        // Dispatch an event to show the modal
        $this->dispatch('addPermissionFormModal');
    }
    public function storePermission()
    {

        $this->validate([
            'name' => ['required', Rule::unique('permissions')->ignore($this->edit_id)],
            'group_name' => 'required',
        ]);

        if ($this->edit_id) {
            Permissions::findOrFail($this->edit_id)->update([
                'name' => $this->name,
                'group_name' => $this->group_name
            ]);
            session()->flash('success', 'Permissions Updated Successfully!');
        } else {
            Permissions::create([
                'name' => $this->name,
                'group_name' => $this->group_name
            ]);
            session()->flash('success', 'Permissions Added Successfully!');
        }

        $this->edit_id = null;
        //  $this->name = $this->group_name =  '';
        $this->reset();
        $this->dispatch('closePermissionModal');

    }
    public function editPermissionModal($id)
    {
        $permission = Permissions::findOrFail($id);
        $this->edit_id = $permission->id;
        $this->name = $permission->name;
        $this->group_name = $permission->group_name;
        $this->clearValidation();
        $this->dispatch('editPermissionFormModal');
    }
    public function deletePermissionModal($id)
    {
        if ($id != '') {
            $this->delete_id = $id;
        }

        $this->dispatch('deletePermissionConfirmationModal');
    }
    public function deletePermission()
    {

        if ($this->delete_id != '') {
            Permissions::findOrFail($this->delete_id)->delete();
            $this->delete_id = '';
        }

        if (count($this->selectedIds)) {
            Permissions::whereIn('id', $this->selectedIds)->delete();
            $this->selectedIds = [];
        }

        session()->flash('success', 'Permissions Deleted Successfully!');
        $this->dispatch('closePermissionModal');
    }
    public function resetSelected()
    {
        $this->selectedIds = [];
        $this->selectAll = false;
    }
    public function updatedSelectedIds()
    {
        if (count($this->selectedIds) == $this->perPage) {
            $this->selectAll = true;
        } else {
            $this->selectAll = false;
        }
    }
    public function updatedSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedIds = Permissions::search($this->search)
                ->orderBy($this->sortColumn, $this->sortDirection)
                ->paginate($this->perPage)
                ->pluck('id');
        } else {
            $this->selectedIds = [];
        }
    }

    public function doSort($column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = ($this->sortDirection == 'ASC') ? 'DESC' : 'ASC';
            $this->dispatch('livewire:updated');
            return;
        }
        $this->sortColumn = $column;
        $this->sortDirection = 'ASC';
        $this->dispatch('livewire:updated');
    }
    public function render()
    {
        return view('livewire.backend.roles.all-permissions', [
            'permissions' => Permissions::search($this->search)
                ->orderBy($this->sortColumn, $this->sortDirection)
                ->paginate($this->perPage)
                ->withQueryString()
        ]);

      
    }
}
