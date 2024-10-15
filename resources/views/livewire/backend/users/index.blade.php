<div>
    <div wire:loading.class="show" wire:target="paginationLoading" class="full-page-loader">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div wire:loading.class="show" wire:target="deleteModal, deleteRow, nextPage" class="full-page-loader">
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
                        <h5 class="card-title mb-0">Users List</h5>
                    </div>
                    <div class="dt-action-buttons text-end pt-3 pt-md-0">
                        <div class="dt-buttons">
                            @can('add.user')
                                <a   href="{{ route('add.user') }}" class="btn btn-primary"><span><i
                                            class="bx bx-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Add
                                            New User</span></span></a>
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
                                    placeholder="Name/Username/Email"></label></div>

                    </div>
                </div>
                <div class="row mx-4">
                    <div class="col-sm-12 col-md-6">

                        @if ($selectedIds)
                            <div class=" m-2">
                                @can('delete.user')
                                    <button class="btn btn-danger" wire:click="deleteModal('')">Delete
                                        {{ count($selectedIds) }} Item(s)</button>
                                @endcan
                            </div>
                        @endif

                    </div>
                    <div class="col-sm-12 col-md-6 d-flex justify-content-end ">
                        {{ $admins->onEachSide(1)->links('livewire::bootstrap') }}
                    </div>
                </div>

                <div class="position-relative">

                    <div wire:loading.class="d-block" wire:target="search, perPage, doSort, selectAll"  wire:loading.remove.class="d-none"
                        class="d-none position-absolute w-100 h-100 d-flex justify-content-center align-items-center"
                        style="background: rgba(255, 255, 255, 0.7); z-index: 10;">
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                <table class="datatables-basic table border-top dataTable no-footer dtr-column" id="DataTables_Table_0"
                    aria-describedby="DataTables_Table_0_info" style="width: 1390px;">
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
                                wire:click="doSort('name')">Name</th>
                            <th class="sorting @if ($sortColumn == 'username' && $sortDirection == 'ASC') sorting_desc
                                    @elseif ($sortColumn == 'username' && $sortDirection == 'DESC')
                                    sorting_asc @endif"
                                wire:click="doSort('username')">Username</th>
                            <th class="sorting @if ($sortColumn == 'email' && $sortDirection == 'ASC') sorting_desc
                                @elseif ($sortColumn == 'email' && $sortDirection == 'DESC')
                                sorting_asc @endif"
                                wire:click="doSort('email')">Email</th>
                            <th>Role</th>
                            <th>Action</th>


                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $key => $item)
                            <tr>
                                <td class=" dt-checkboxes-cell">
                                    <input type="checkbox" wire:key='{{ $item->id }}' value='{{ $item->id }}'
                                        wire:model.live='selectedIds' class="dt-checkboxes form-check-input">
                                </td>
                                <td class=" dt-checkboxes-cell">{{ $admins->firstItem() + $key }}</td>
                                <td>
                                    {{ $item->name }}


                                </td>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    @foreach ($item->roles as $role)
                                        <span class="badge badge-pill bg-primary">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <div class="d-inline-block text-nowrap">
                                        @can('edit.user')
                                            <a  href="{{ route('edit.user', $item->id) }}"
                                                class="btn btn-icon btn-sm btn-primary btn-icon"><i
                                                    class="bx bx-edit"></i></a>
                                        @endcan
                                        @can('delete.user')
                                            <a href="#" wire:click.prevent='deleteModal({{ $item->id }})'
                                                class="btn btn-sm btn-icon btn-danger delete-record"><i
                                                    class="bx bx-trash"></i></a>
                                        @endcan

                                    </div>


                                </td>

                            </tr>
                        @endforeach

                        @if (!count($admins))
                            <tr class="odd">
                                <td valign="top" colspan="7" class="text-center">No data available in table</td>
                            </tr>
                        @endif


                </table>
            </div>
            <div class="row mx-4">
                <div class="col-sm-12 col-md-6">

                    @if ($selectedIds)
                        <div class=" m-2">
                            @can('delete.user')
                                <button class="btn btn-danger" wire:click="deleteModal('')">Delete
                                    {{ count($selectedIds) }} Item(s)</button>
                            @endcan
                        </div>
                    @endif

                </div>
                <div class="col-sm-12 col-md-6 d-flex justify-content-end ">
                    {{ $admins->onEachSide(1)->links('livewire::bootstrap') }}
                </div>
            </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="">Are you sure you want to delete?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" wire:click='deleteRow()'>Yes!
                        Delete</button>
                </div>

            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        document.addEventListener('closeModal', () => {
            $('.modal').modal('hide');
        });

        Livewire.on('paginationLoading', () => {
        console.log('paginationLoading');
    });
        document.addEventListener('deleteConfirmationModal', () => {
            $('#deleteConfirmationModal').modal('show');
        });
        $('.page-item').on('click', function() {
            Livewire.dispatch('resetSelectedIds');
        });
    </script>
@endpush
