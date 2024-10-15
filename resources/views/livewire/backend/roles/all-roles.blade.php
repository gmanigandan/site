<div>
    <div wire:loading.class="show"
        wire:target="showAddRolesModal, deleteRoleModal, storeRole, deleteRoleModal, nextPage,deleteRole,editRoleModal"
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
                        <h5 class="card-title mb-0">All Roles</h5>
                    </div>
                    <div class="dt-action-buttons text-end pt-3 pt-md-0">
                        <div class="dt-buttons">
                            @can('add.role')
                                <button class="btn btn-primary" wire:click="showAddRolesModal"><span><i
                                            class="bx bx-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Add
                                            New Role</span></span></button>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="dataTables_length" id="DataTables_Table_0_length"><label>Show
                                <select wire:model.live="perPage" class="form-select">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="75">75</option>
                                    <option value="100">100</option>
                                </select> entries</label></div>
                    </div>
                    <div class="col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end">





                        <div class="dataTables_filter"><label>Search:
                                <input wire:model.live="search" type="search" class="form-control"
                                    placeholder=""></label></div>

                    </div>
                </div>
                <div class="row mx-4">
                    <div class="col-sm-12 col-md-6">

                        @if ($selectedIds)
                            <div class=" m-2">
                                @can('delete.role')
                                    <button class="btn btn-danger" wire:click="deleteRoleModal('')">Delete
                                        {{ count($selectedIds) }} Item(s)</button>
                                @endcan
                            </div>
                        @endif

                    </div>
                    <div class="col-sm-12 col-md-6 d-flex justify-content-end ">
                        {{ $roles->onEachSide(1)->links('livewire::bootstrap') }}
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
                                    wire:click="doSort('name')">Role Name</th>

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
                                        <div class="d-inline-block text-nowrap">
                                            @can('edit.role')
                                                <a class="btn btn-sm btn-icon btn-primary" href="#"
                                                    wire:click.prevent='editRoleModal({{ $item->id }})'><i
                                                        class="bx bx-edit"></i></a>
                                            @endcan
                                            @can('delete.role')
                                                <a href="#" wire:click.prevent='deleteRoleModal({{ $item->id }})'
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
                            <div class="  me-2">
                                @can('delete.role')
                                    <button class="btn btn-danger" wire:click="deleteRoleModal('')">Delete
                                        {{ count($selectedIds) }} Item(s)</button>
                                @endcan
                            </div>
                        @endif

                    </div>
                    <div class="col-sm-12 col-md-6 d-flex justify-content-end ">
                        {{ $roles->onEachSide(1)->links('livewire::bootstrap') }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="RoleFormModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="RoleFormModalLabel">Add Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent='storeRole()' id="roleForm">
                        <input type="hidden" wire:model="edit_id">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameLarge" class="form-label">Name</label>
                                <input type="text" class="form-control" placeholder="Enter Role Name"
                                    wire:model="name">
                                @error('name')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" wire:click="storeRole" class="btn btn-primary">Save</button>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteRoleConfirmationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="deleteRoleFormModalLabel">Delete Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="">Are you sure you want to delete?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" wire:click='deleteRole({{ $delete_id }})'>Yes!
                        Delete</button>
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
        document.addEventListener('addRoleFormModal', () => {
            console.log('sdsd');
            addRoleFormModal();
        });

        function addRoleFormModal() {
            $('#RoleFormModalLabel').html('Add Role');
            $('#RoleFormModal').modal('show');
        }

        document.addEventListener('editRoleFormModal', () => {
            $('#RoleFormModalLabel').html('Edit Role');
            $('#RoleFormModal').modal('show');
        });
        document.addEventListener('deleteRoleConfirmationModal', () => {
            $('#deleteRoleConfirmationModal').modal('show');
        });
        $('.page-item').on('click', function() {
            Livewire.dispatch('resetSelectedIds');
        });
    </script>
@endpush
