@extends('admins.master')

@section('sales_active', 'active')

@section('title', 'Sales')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Sales Report</h5>
                    </div>
                    <div class="ibox-content">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4>Reports List</h4>
                                    </div>
                                    <div class="panel-body">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <a href="{{ url('/admin/product-sales-report') }}"
                                                    class="btn btn-primary btn-block">
                                                    📊 Product Sales Report
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                <a href="{{ url('/admin/category-sales-report') }}"
                                                    class="btn btn-success btn-block">
                                                    📈 Category Sales Report
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                <a href="{{ url('/admin/monthly-sales-report') }}"
                                                    class="btn btn-info btn-block">
                                                    📅 Monthly Sales Report
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                <a href="{{ url('/admin/monthly-odoo-report') }}"
                                                    class="btn btn-danger btn-block">
                                                    📅 Monthly Odoo Report
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                <a href="{{ route('admins.general-ledger') }}"
                                                    class="btn btn-success btn-block">
                                                    📈 General Ledger
                                                </a>
                                            </li>
                                            <li class="list-group-item">
                                                <a href="{{ route('admins.vat-report-view') }}"
                                                    class="btn btn-warning btn-block">
                                                    💰 VAT Report
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- ibox-content -->
                </div> <!-- ibox -->
            </div>
        </div>
    </div>
@endsection
