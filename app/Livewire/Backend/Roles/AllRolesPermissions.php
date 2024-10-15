<?php
namespace App\Livewire\Backend\Roles;

use Livewire\Component;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;
use App\Models\Backend\Admin;
use Livewire\Attributes\Layout;
#[Layout('components.layouts.admin-dashboard')] 
class AllRolesPermissions extends Component
{
    use WithPagination;
    public $perPage = 5;
    public $search = '';
    public $delete_id =  '';
    public $role_id = '';
    public $checkboxGroup = [];
    public $checkboxPermissions = [];
    public $selectAllPermission = false;

    public $edit_id = '';
    public $sortColumn = 'name';
    public $sortDirection = 'ASC';
    public $selectedIds = [];
    public $selectAll = false;

    public $listeners = ['resetSelectedIds' => 'resetSelected', 'refreshComponents' => '$refresh'];


    public function mount()
    {
        $this->perPage = request()->query('perPage', $this->perPage);
        //$this->checkboxPermissions = ['add.admin'];

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
            $this->selectedIds = Role::orderBy($this->sortColumn, $this->sortDirection)
                ->paginate($this->perPage)
                ->pluck('id')->toArray();
        } else {
            $this->selectedIds = [];
        }
    }
    public function updatingPerPage()
    {
        $this->resetPage();
    }
    public function updatedPerPage()
    {
        $this->resetPage();
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function doSort($column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = ($this->sortDirection == 'ASC') ? 'DESC' : 'ASC';
            return;
        }
        $this->sortColumn = $column;
        $this->sortDirection = 'ASC';
    }
    public function checkCheckboxPermissions()
    {

        $allGroups = Permission::groupBy('group_name')->pluck('group_name');
        $totalItms = 0;
        foreach ($allGroups as $group_name) {
            $groupNames = Permission::where('group_name', $group_name)->pluck('name')->toArray();
            $totalItms += count($groupNames);
            if (count(array_intersect($groupNames, $this->checkboxPermissions)) == count($groupNames)) {
                $this->checkboxGroup = array_unique(array_merge($this->checkboxGroup, [$group_name]));
            } else {
                $this->checkboxGroup = array_diff($this->checkboxGroup, [$group_name]);
            }
            if(!empty($this->checkboxGroup))$this->checkboxGroup = array_values($this->checkboxGroup);
        }
        if (count($this->checkboxPermissions) == $totalItms) {
            $this->selectAllPermission = true;
        } else {
            $this->selectAllPermission = false;
        }

    }
    public function updatedCheckboxPermissions()
    {


       $this->checkCheckboxPermissions();
    }

    public function changeCheckboxGroup($group_name_check)
    {

        $allGroups = Permission::groupBy('group_name')->pluck('group_name');
        $totalItms = 0;
        foreach ($allGroups as $group_name) {
            $groupNames = Permission::where('group_name', $group_name)->pluck('name')->toArray();
            $totalItms += count($groupNames);
            if($group_name_check == $group_name){

                if (in_array($group_name, $this->checkboxGroup)) {

                    $this->checkboxPermissions = array_unique(array_merge($this->checkboxPermissions, $groupNames));
                } else {
                    $this->checkboxPermissions = array_diff($this->checkboxPermissions, $groupNames);
                }
                if(!empty($this->checkboxPermissions))$this->checkboxPermissions = array_values($this->checkboxPermissions);
            }

        }
        if (count($this->checkboxPermissions) == $totalItms) {
            $this->selectAllPermission = true;
        } else {
            $this->selectAllPermission = false;
        }
        $this->dispatch('refreshComponents');

    }
    public function updatedSelectAllPermission()
    {
        if ($this->selectAllPermission) {
            $this->checkboxPermissions = Permission::all()->pluck('name')->toArray();
            $this->checkboxGroup = Permission::groupBy('group_name')->pluck('group_name')->toArray();
        } else {
            $this->checkboxPermissions = [];
            $this->checkboxGroup = [];
        }
    }
    public function createRolePermissionModal()
    {
        $this->selectAllPermission = false;
        $this->checkboxPermissions = [];
        $this->checkboxGroup = [];
        $this->role_id = '';
        $this->clearValidation();
        $this->dispatch('createRoleFormModal');
    }
    public function editRolePermissionModal($role_id)
    {
        $this->role_id = $role_id;
        $role = Role::findOrFail($role_id);
        $this->checkboxPermissions = $role->getPermissionNames()->toArray();
        $this->checkCheckboxPermissions();
        $this->clearValidation();

        $this->dispatch('editRoleFormModal');
    }
    public function deleteRolePermissionModal($id)
    {
        if($id != ''){
            $this->delete_id = $id;
        }

        $this->dispatch('deleteConfirmationModal');

    }
    public function deleteRolePermission() {

        if($this->delete_id != ''){
            $role = Role::findOrFail($this->delete_id);
            $role->syncPermissions([]);
            $this->delete_id = '';
        }

        if(count($this->selectedIds)){
            foreach($this->selectedIds as $id){
                $role = Role::findOrFail($id);
                $role->syncPermissions([]);
            }

            $this->selectedIds = [];
        }

        session()->flash('success', 'Roles in permissions deleted successfully!');
        $this->dispatch('closeRoleModal');
    }
    public function storeRolePermission()
    {


        $this->validate([
            "role_id" => "required",
            // "checkboxPermissions" => "required|array",
        ]);
        $role = Role::findOrFail($this->role_id);
        $role->syncPermissions($this->checkboxPermissions);
        session()->flash('success', 'Role in permissions saved successfully!');
        $this->role_id = '';
        $this->checkboxPermissions = [];

        $this->dispatch('closeRoleModal');

    }


    public function render()
    {
        $permission_groups = Admin::getPermissionGroups();
        return view('livewire.backend.roles.all-roles-permissions', [
            'roles' => Role::all(),
            'permission_groups' => $permission_groups

        ]);
    }
}

