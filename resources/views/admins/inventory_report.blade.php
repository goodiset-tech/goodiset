@extends('admins.master')

@section('title', 'Inventory Report')
@section('product_inventory', 'active')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Product Inventory Report</h5>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table id="inventoryReportTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Product Quantity</th>
                                <th>Weight per Piece(grams)</th>
                                <th>Total Weight (grams)</th>
                                <th>Qunatity Per Piece</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            let table = $('#inventoryReportTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admins.products.inventory.report.data') }}",
                pageLength: 20,
                lengthMenu: [10, 20, 25, 50, 100],
                lengthChange: true,
                dom: '<"row mb-2"<"col-sm-6"l><"col-sm-6 text-right"B>>' +
                    '<"row"<"col-sm-12"tr>>' +
                    '<"row mt-2"<"col-sm-6"i><"col-sm-6"p>>',
                buttons: [{
                        extend: 'csvHtml5',
                        text: 'Export CSV',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Export Excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Export PDF',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ],
                columns: [{
                        data: 'sku',
                        name: 'sku'
                    },
                    {
                        data: 'product_name',
                        name: 'product_name'
                    },
                    {
                        data: 'price',
                        name: 'price',
                        orderable: false
                    },
                    {
                        data: 'product_quantity',
                        name: 'product_quantity'
                    },
                    {
                        data: 'weight_per_unit',
                        name: 'weight_per_unit',
                        orderable: false
                    },
                    {
                        data: 'total_weight',
                        name: 'total_weight',
                        orderable: false
                    },
                    {
                        data: 'quantity_by_unit',
                        name: 'quantity_by_unit',
                        orderable: false
                    }
                ],
                order: [
                    [1, 'asc']
                ]
            });



            //  // Ensure export includes full filtered data, not just current page
            // table.on('preXhr.dt', function(e, settings, data) {
            //     data.length = -1; // fetch all records for export/print
            // });

            // table.on('buttons-action', function(e, buttonApi, dataTable, node, config) {
            //     // reset back to current page after export
            //     $('#inventoryReportTable').DataTable().ajax.reload(null, false);
            // });

            $(document).on('change', '.weight-input', function() {
                let input = $(this);
                let productId = input.data('id');
                let newWeight = input.val();

                $.ajax({
                    url: '{{ route('admins.products.update.weight') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        weight_per_unit: newWeight
                    },
                    success: function(res) {
                        if (res.success) {
                            input.css('border-color', 'green');
                            table.ajax.reload(null, false);
                        } else {
                            input.css('border-color', 'red');
                            alert(res.message || 'Failed to update.');
                        }
                    },
                    error: function() {
                        input.css('border-color', 'red');
                        alert('An error occurred.');
                    }
                });
            });
        });
    </script>
@endpush
