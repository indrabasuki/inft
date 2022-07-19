@extends('layouts.app')

@section('content')
<x-nav></x-nav>
    <div class="row ">
        <div class="col-md-12">
            <h5 class="mt-5 mb-2">Refrerral Code</h5>
            <div class="row mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control form-rounded" placeholder="Search">
                </div>
                <div class="col-md-8">
                    <button class="btn btn-success rounded-pill float-end"id="addNew"><i class="fas fa-plus"></i> Add
                        Referral
                        Code</button>
                </div>
            </div>
            <div class="table-responsive-xl">
                <table class="table table-borderless">
                    <thead>
                        <th>No.</th>
                        <th>Referral Code</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Added By</th>
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

    <div class="modal fade" id="add" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 25px">

                <div class="modal-body">
                    <div class="mb-2 mt-3">
                        <h4 class="modal-title">Add New Referral Code</h4>
                    </div>
                    <form action="javascript:void(0)" id="addForm" name="addForm" class="form-horizontal" method="POST">

                        <div class="form-group">
                            <label for="name" class="col-sm-6 mb-1 control-label">Referral Code</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control form-rounded" id="referral_code"
                                    name="referral_code" placeholder="Enter Type Name" value="" maxlength="50"
                                    required>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label for="name" class="col-sm-6 mb-1 control-label">Type</label>
                            <div class="col-sm-12">
                                <select name="referral_type_id" id="referral_type_id" class="form-control form-rounded">
                                    @foreach (App\Models\ReferralType::all() as $item)
                                        <option value="{{ $item->id }}">{{ Str::upper($item->type_name) }}
                                        </option>
                                    @endforeach
                                </select>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label for="name" class="col-sm-2 mb-1 control-label">Description</label>
                            <div class="col-sm-12">
                                <textarea name="referral_description" class="form-control form-rounded" id="referral_description" cols="30"
                                    rows="3"></textarea>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-3">

                            <button type="submit" class="rounded-pill   btn btn-success float-end" id="btn-save">Submit
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

    <div class="modal fade" id="update-ref" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 25px">

                <div class="modal-body">
                    <div class="mb-2 mt-3">
                        <h4 class="modal-title">Update Referral Type</h4>
                    </div>
                    <form action="javascript:void(0)" id="editForm" class="form-horizontal" method="POST">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="name" class="col-sm-6 mb-1 control-label">Referral Code</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control form-rounded" id="code" name="code"
                                    placeholder="Enter Referral Code" maxlength="50" required>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label for="name" class="col-sm-6 mb-1 control-label">Type</label>
                            <div class="col-sm-12">
                                <select name="type_id" id="type_id" class="form-control form-rounded">
                                    @foreach (App\Models\ReferralType::all() as $item)
                                        <option value="{{ $item->id }}">{{ Str::upper($item->type_name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label for="name" class="col-sm-2 mb-1 control-label">Description</label>
                            <div class="col-sm-12">
                                <textarea name="description" class="form-control form-rounded" id="description" cols="30" rows="3"></textarea>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-3">

                            <button type="submit" class="rounded-pill   btn btn-success float-end"
                                id="btn-update">Update
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
        var _sortTemp = "referral.created_at";
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

            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                getData($(this).attr('data-href'));
            });

            $(document).on('click', '#cancel', function(e) {
                $('#add').modal('hide');
                $('#update-ref').modal('hide');
            });

            $(document).on('click', '#addNew', function(e) {
                $('#addForm').trigger("reset");
                $('#add').modal('show');
            });

            $('body').on('click', '#btn-save', function(event) {
                var referral_code = $("#referral_code").val();
                var referral_description = $("#referral_description").val();
                var referral_type_id = $("#referral_type_id").val();
                $("#btn-save").html('Please Wait...');
                $("#btn-save").attr("disabled", true);
                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ route('referral.store') }}",
                    data: {
                        referral_type_id: referral_type_id,
                        referral_code: referral_code,
                        referral_description: referral_description,
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
                var referral_code = $("#code").val();
                var referral_description = $("#description").val();
                var type_id = $("#type_id").val();

                $("#btn-update").html('Please Wait...');
                $("#btn-update").attr("disabled", true);
                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ route('referral.update') }}",
                    data: {
                        id: id,
                        referral_type_id: type_id,
                        referral_code: referral_code,
                        referral_description: referral_description,
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
            if (confirm("Are you sure want to remove this record ?") == true) {
                var id = $(this).data('id');

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ route('referral.destroy') }}",
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
                url: "{{ route('referral.edit') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#update-ref').modal('show');
                    $('#id').val(res.id);
                    $('#code').val(res.referral_code);
                    $('#description').val(res.referral_description);
                }
            });
        });



        function getData(page) {
            var filterName = $("input[name='search']").val()

            var url = "{{ route('referral') }}?page=" + page + "&name=" + filterName + "&sort=" + _sort +
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
