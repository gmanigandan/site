<?php

namespace App\Livewire\Backend\Roles;
use Livewire\Component;
use App\Models\Backend\Role;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
#[Layout('components.layouts.admin-dashboard')] 
class AllRoles extends Component
{
    use WithPagination;
    public $perPage = 5;
    public $search = '';
    public $delete_id =  '';
    public $edit_id =  '';
    public $sortColumn = 'name';
    public $sortDirection = 'ASC';
    public $selectedIds =[];
    public $selectAll = false;
    public $listeners = ['resetSelectedIds' => 'resetSelected'];
    public $name;

    public function editRoleModal($id) {
        $role = Role::findOrFail($id);
        $this->edit_id = $role->id;
        $this->name = $role->name;
        $this->clearValidation();
        $this->dispatch('editRoleFormModal');
    }
    public function deleteRoleModal($id) {
        if($id != ''){
            $this->delete_id = $id;
        }

        $this->dispatch('deleteRoleConfirmationModal');
    }
    public function deleteRole() {

        if($this->delete_id != ''){
            Role::findOrFail($this->delete_id)->delete();
            $this->delete_id = '';
        }

        if(count($this->selectedIds)){
            Role::whereIn('id', $this->selectedIds)->delete();
            $this->selectedIds = [];
        }

        session()->flash('success', 'Roles Deleted Successfully!');
        $this->dispatch('closeRoleModal');
    }
    public function showAddRolesModal()
    {
        // Clear any existing form data
        $this->reset();
        $this->clearValidation();
        // Dispatch an event to show the modal
        $this->dispatch('addRoleFormModal');
    }
    public function storeRole()
    {

            $this->validate([
                'name' => 'required|unique:roles,name,'.($this->edit_id ? $this->edit_id : 'null'),
            ]);

            if($this->edit_id != ''){
                Role::findOrFail($this->edit_id)->update([
                    'name' => $this->name,
                ]);
                session()->flash('success', 'Roles Updated Successfully!');
            }else{
                Role::create([
                    'name' => $this->name,
                ]);
                session()->flash('success', 'Roles Added Successfully!');
            }


            $this->name = $this->edit_id = '';

            $this->dispatch('closeRoleModal');

    }
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
        if (count($this->selectedIds) == $this->perPage) {
            $this->selectAll = true;
        } else {
            $this->selectAll = false;
        }
    }
    public function updatedSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedIds = Role::search($this->search)
                ->orderBy($this->sortColumn, $this->sortDirection)
                ->paginate($this->perPage)
                ->pluck('id');
        } else {
            $this->selectedIds = [];
        }
    }
    public function updatingPerPage()
    {
        $this->resetPage();
    }
    // Life cycle hooks
    public function updatedPerPage(){
        $this->resetPage();
    }
    public function updatedSearch(){
        $this->resetPage();
    }
    public function doSort($column) {
        if($this->sortColumn === $column) {
            $this->sortDirection = ($this->sortDirection == 'ASC') ?'DESC':'ASC';
            return;
        }
        $this->sortColumn = $column;
        $this->sortDirection = 'ASC';
    }
    public function render()
    {
        return view('livewire.backend.roles.all-roles',[
            'roles' => Role::search($this->search)
                        ->orderBy($this->sortColumn, $this->sortDirection)
                        ->paginate($this->perPage)
                        ->withQueryString() //for page & offset number
        ]);
    }
}
