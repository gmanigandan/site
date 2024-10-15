<div>
    <div wire:loading.class="show"
        wire:target="createRolePermissionModal, deleteRolePermissionModal, editRolePermissionModal, deleteRolePermission, nextPage,storeRolePermission"
        class="full-page-loader">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    @if (Session::get('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            {{ Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (Session::get('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-datatable table-responsive">
            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                <div class="card-header flex-column flex-md-row">
                    <div class="head-label text-center">
                        <h5 class="card-title mb-0">All Roles in Permissions </h5>
                    </div>
                    <div class="dt-action-buttons text-end pt-3 pt-md-0">
                        <div class="dt-buttons">
                            @can('add.roles.permissions')
                                <button class="btn btn-primary" wire:click.prevent='createRolePermissionModal()'><span><i
                                            class="bx bx-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Add
                                            Roles in Permissions</span></span></button>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="row mx-4">
                    <div class="col-sm-12 col-md-6">

                        @if ($selectedIds)
                            <div class=" m-2">
                                @can('delete.roles.permissions')
                                    <button class="btn btn-danger" wire:click="deleteRoleModal('')">Delete
                                        {{ count($selectedIds) }} Item(s)</button>
                                @endcan
                            </div>
                        @endif

                    </div>

                </div>
                <div class="position-relative">

                    <div wire:loading.class="d-block" wire:target="search, perPage, doSort, selectAll"
                        wire:loading.remove.class="d-none"
                        class="d-none position-absolute w-100 h-100 d-flex justify-content-center align-items-center"
                        style="background: rgba(255, 255, 255, 0.7); z-index: 10;">
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <table class="datatables-basic table border-top dataTable no-footer dtr-column"
                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="width: 1390px;">
                        <thead>
                            <tr>

                                <th class="dt-checkboxes-cell dt-checkboxes-select-all" style="width: 18px;">
                                    <input type="checkbox" wire:model.live='selectAll' class="form-check-input">
                                </th>
                                <th style="width: 18px;">
                                    #
                                </th>
                                <th class="sorting @if ($sortColumn == 'name' && $sortDirection == 'ASC') sorting_desc
                            @elseif ($sortColumn == 'name' && $sortDirection == 'DESC')
                            sorting_asc @endif"
                                    wire:click="doSort('name')">Role</th>
                                <th>Permission</th>
                                <th>Action</th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $item)
                                <tr>
                                    <td class=" dt-checkboxes-cell">
                                        <input type="checkbox" wire:key='{{ $item->id }}'
                                            value='{{ $item->id }}' wire:model.live='selectedIds'
                                            class="dt-checkboxes form-check-input">
                                    </td>
                                    <td class=" dt-checkboxes-cell">{{ $key + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        @foreach ($item->permissions as $perm)
                                            <span class="badge bg-secondary">{{ $perm->name }}</span>
                                        @endforeach

                                    </td>
                                    <td>
                                        <div class="d-inline-block text-nowrap">
                                            @can('edit.roles.permissions')
                                                <a class="btn btn-sm btn-icon btn-primary" href="#"
                                                    wire:click.prevent='editRolePermissionModal({{ $item->id }})'><i
                                                        class="bx bx-edit"></i></a>
                                            @endcan
                                            @can('delete.roles.permissions')
                                                <a href="#"
                                                    wire:click.prevent='deleteRolePermissionModal({{ $item->id }})'
                                                    class="btn btn-sm btn-icon btn-danger delete-record"><i
                                                        class="bx bx-trash"></i></a>
                                            @endcan

                                        </div>


                                    </td>

                                </tr>
                            @endforeach

                            @if (!count($roles))
                                <tr class="odd">
                                    <td valign="top" colspan="4" class="text-center">No data available in table
                                    </td>
                                </tr>
                            @endif


                    </table>
                </div>
                <div class="row mx-4">
                    <div class="col-sm-12 col-md-6">

                        @if ($selectedIds)
                            <div class=" m-2">
                                @can('delete.roles.permissions')
                                    <button class="btn btn-danger" wire:click="deleteRoleModal('')">Delete
                                        {{ count($selectedIds) }} Item(s)</button>
                                @endcan
                            </div>
                        @endif

                    </div>

                </div>


            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="RoleFormModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="RoleFormModalLabel">Add Roles in Permissions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form wire:submit='storeRolePermission()'>

                        <input type="hidden" wire:model="edit_id">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="role_id" class="form-label">Select Role</label>
                                <div class="position-relative">
                                    <select class="form-select" id="role_id" wire:model="role_id">
                                        <option value="" selected>Select Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('role_id')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror


                            </div>
                            <div class="col mt-4">
                                <input type="checkbox" class="form-check-input" id="checkDefaultMain"
                                    wire:model.live='selectAllPermission'>
                                <label class="form-check-label" for="checkDefaultMain">
                                    All Permission
                                </label>
                            </div>
                        </div>
                        {{-- @dump($checkboxGroup) --}}

                        <hr>
                        @foreach ($permission_groups as $group)
                            <div class="row mb-3">
                                <div class="col-3">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input checkGroup"
                                            wire:model.live="checkboxGroup" id="checkGroup_{{ $group->group_name }}"
                                            wire:click="changeCheckboxGroup('{{ $group->group_name }}')"
                                            value="{{ $group->group_name }}">
                                        <label class="form-check-label" for="checkGroup_{{ $group->group_name }}">
                                            {{ $group->group_name }}
                                        </label>
                                    </div>
                                </div>

                                <div class="col-9">
                                    @php
                                        $groupPerm = App\Models\Backend\Admin::getPermissionByGroupName(
                                            $group->group_name,
                                        );
                                    @endphp
                                    <div class="row">
                                        @foreach ($groupPerm as $permission)
                                            <div class="col-3">
                                                <div class="form-check form-check-inline mb-2">
                                                    <input
                                                        id="checkGroup_{{ $group->group_name }}-{{ $permission->id }}"
                                                        type="checkbox" value="{{ $permission->name }}"
                                                        wire:model.live="checkboxPermissions"
                                                        class="dt-checkboxes form-check-input">


                                                    <label class="form-check-label"
                                                        for="checkGroup_{{ $group->group_name }}-{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <br>

                                </div>

                            </div>
                        @endforeach

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" wire:click="storeRolePermission" class="btn btn-primary">Save</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteRoleConfirmationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRoleFormModalLabel">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="">Are you sure you want to remove permissions?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" wire:click='deleteRolePermission()'>Yes!  Remove</button>
                </div>

            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        document.addEventListener('closeRoleModal', () => {
            $('.modal').modal('hide');
        });
        document.addEventListener('createRoleFormModal', () => {
            $('#RoleFormModalLabel').html('Edit Roles in Permissions');
            $('#RoleFormModal').modal('show');
        });

        document.addEventListener('editRoleFormModal', () => {
            $('#RoleFormModalLabel').html('Edit Roles in Permissions');
            $('#RoleFormModal').modal('show');
        });
        document.addEventListener('deleteConfirmationModal', () => {
            $('#deleteRoleConfirmationModal').modal('show');
        });

        $('.page-item').on('click', function() {
            Livewire.dispatch('resetSelectedIds');
        });
    </script>
@endpush
