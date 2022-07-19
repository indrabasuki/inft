@extends('layouts.app')
@section('content')
    <x-nav></x-nav>

    <div class="row ">
        <div class="col-md-12">
            <h5 class="mt-5 mb-2">Refrerral Type</h5>
            <div class="row mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control form-rounded" placeholder="Search">
                </div>
                <div class="col-md-8">
                    <button class="btn btn-success rounded-pill float-end"id="addNew"><i class="fas fa-plus"></i> Add
                        Referral
                        Type</button>
                </div>
            </div>
            <div class="table-responsive-xl">
                <table class="table table-borderless">
                    <thead>
                        <th>No.</th>
                        <th>Type Name</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>..</th>
                    </thead>
                    <tbody id="table-content">
                    </tbody>
                </table>
                <div class="float-end" id="paginate"></div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="ajax-ref-model" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 25px">

                <div class="modal-body">
                    <div class="mb-2 mt-3">
                        <h4 class="modal-title" id="ajaxRefModel"></h4>
                    </div>
                    <form action="javascript:void(0)" id="addEditRefForm" name="addEditRefForm" class="form-horizontal"
                        method="POST">
                        <input type="hidden" name="id" id="id">

                        <div class="form-group">
                            <label for="name" class="col-sm-2 mb-1 control-label">Type Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control form-rounded" id="type_name" name="type_name"
                                    placeholder="Enter Type Name" value="" maxlength="50" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 mb-1 control-label">Description</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control form-rounded" id="type_description"
                                    name="type_description" placeholder="Enter Type Description" value=""
                                    maxlength="50" required>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-3">

                            <button type="submit" class="rounded-pill   btn btn-success float-end" id="btn-save"
                                value="addNewRef">Save
                                changes
                            </button>
                            <button class="rounded-pill btn btn-default border border-secondary float-end " id="cancel">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="update" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 25px">

                <div class="modal-body">
                    <div class="mb-2 mt-3">
                        <h4 class="modal-title">Update Referral Type</h4>
                    </div>
                    <form action="javascript:void(0)" id="editForm" class="form-horizontal" method="POST">
                        <input type="hidden" name="id" id="id">

                        <div class="form-group">
                            <label for="name" class="col-sm-2 mb-1 control-label">Type Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control form-rounded" id="type_name" name="type_name"
                                    placeholder="Enter Type Name" value="" maxlength="50" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-sm-2 mb-1 control-label">Description</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control form-rounded" id="type_description"
                                    name="type_description" placeholder="Enter Type Description" value=""
                                    maxlength="50" required>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-3">

                            <button type="submit" class="rounded-pill   btn btn-success float-end" id="btn-update"
                                value="addNewRef">Update
                            </button>
                            <button class="rounded-pill btn btn-default border border-secondary float-end "
                                id="cancel">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        var _sortTemp = "referral_types.created_at";
        var _currentPage = 1;
        var _sort = "asc";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {

            getData(1);
            $("input[name='search']").keypress(function(e) {
                if (e.which == 13) {
                    getData(1);
                }
            });

            $(document).on('click', '#cancel', function(e) {
                $('#ajax-ref-model').modal('hide');
                $('#update').modal('hide');
            });
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                getData($(this).attr('data-href'));
            });


            $(document).on('click', '#addNew', function(e) {
                $('#addEditRefForm').trigger("reset");
                $('#ajaxRefModel').html("Add New Referal Type");
                $('#ajax-ref-model').modal('show');
            });

            $('body').on('click', '#btn-save', function(event) {
                var type_name = $("#type_name").val();
                var type_description = $("#type_description").val();
                $("#btn-save").html('Please Wait...');
                $("#btn-save").attr("disabled", true);
                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ route('referral_type.store') }}",
                    data: {
                        type_name: type_name,
                        type_description: type_description,
                    },
                    dataType: 'json',
                    success: function(res) {
                        window.location.reload();
                        $("#btn-save").html('Submit');
                        $("#btn-save").attr("disabled", false);
                    }
                });
            });

            $('body').on('click', '#btn-update', function(event) {
                var id = $("#id").val();
                var type_name = $("#type_name").val();
                var type_description = $("#type_description").val();
                $("#btn-update").html('Please Wait...');
                $("#btn-update").attr("disabled", true);
                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ route('referral_type.update') }}",
                    data: {
                        id: id,
                        type_name: type_name,
                        type_description: type_description,
                    },
                    dataType: 'json',
                    success: function(res) {
                        window.location.reload();
                        $("#btn-save").html('Submit');
                        $("#btn-save").attr("disabled", false);
                    }
                });
            });

        });

        $('body').on('click', '.delete', function() {
            if (confirm("Delete Record?") == true) {
                var id = $(this).data('id');

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ route('referral_type.destroy') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {
                        alert("Record Deleted Successfully");
                        window.location.reload();
                    }
                });
            }
        });

        $('body').on('click', '.edit', function() {
            var id = $(this).data('id');

            // ajax
            $.ajax({
                type: "POST",
                url: "{{ route('referral_type.edit') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#ajaxRefModel').html("EditReferal Type");
                    $('#ajax-ref-model').modal('show');
                    $('#id').val(res.id);
                    $('#type_name').val(res.type_name);
                    $('#type_description').val(res.type_description);
                }
            });
        });

        function getData(page) {
            var filterName = $("input[name='search']").val()

            var url = "{{ route('referral_type') }}?page=" + page + "&name=" + filterName + "&sort=" + _sort +
                "&sortBy=" + _sortTemp;

            $.ajax({
                method: 'GET',
                url: url,
                dataType: 'json',
            }).done(function(data) {
                $('#table-content').html(data.item);
                $("#paginate").html(data.ul);
                _currentPage = data.current_page;
            }).fail(function(data) {
                alert('Error: ' + data);
            });
        }

        function setSort(obj) {
            _sort = "asc";
            if (obj.attr('data-field')) {

                if (obj.hasClass("desc")) {
                    _sort = "asc";
                    _sortTemp = obj.attr('data-field');
                } else {
                    _sort = "desc";
                    _sortTemp = obj.attr('data-field');
                }

                setSortIcon(_sort);
                getData(_currentPage)
            }
        }
    </script>
@endsection
