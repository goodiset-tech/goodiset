@extends('layout.app')
@php
    use Illuminate\Support\Facades\Session;
@endphp
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <div class="dashboard">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="sidebar">
                        <div class="sidebar_header">
                            <h3>@lang('myaccount.title') {{ Session::get('user')['name'] }}</h3>
                            <button class="account_menu">@lang('myaccount.account_menu')</button>
                        </div>

                        <div class="fullscreen-menu">
                            <ul class="menu">
                                <li class="menu-item active my-account" data-target="my-account">
                                    <a href="#">@lang('myaccount.my_account')</a>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </li>
                                <li class="menu-item" data-target="orders">
                                    <a href="#">@lang('myaccount.orders')</a>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </li>
                                <li class="menu-item" data-target="address">
                                    <a href="#">@lang('myaccount.account_details')</a>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </li>
                                <li class="menu-item" data-target="logout">
                                    <a href="#">@lang('myaccount.logout')</a>
                                    <i class="fa-solid fa-chevron-right"></i>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>


                <div class="col-lg-9 col-md-8 col-12">
                    <div class="content">
                        <!-- Content Tabs -->
                        <div class="tab active-tab" id="my-account">
                            <h3 class="tab-name">@lang('myaccount.my_account')</h3>
                            <div class="main-content">
                                <div class="info">
                                    <h3 class="title">@lang('myaccount.contact_info.title')</h3>
                                    <div class="hr-line"></div>
                                    <div class="row" style="row-gap: 20px">
                                        <div class="col-12 col-sm-6 grid-column">
                                            <div class="contact-info">
                                                <h4>@lang('myaccount.contact_info.title')</h4>
                                                <p>{{ Session::get('user')['name'] }}</p>
                                                <p>{{ Session::get('user')['email'] }}</p>
                                                <div class="links">
                                                    <a href="#" id="edit">@lang('myaccount.contact_info.edit')</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="tab" id="orders">
                            <h3 class="tab-name">@lang('myaccount.orders.title')</h3>
                            <div class="order-table-container">
                                <div class="table-responsive">
                                    <table class="order-table" id="order-table">
                                        <thead>
                                            <tr>
                                                <th>@lang('myaccount.orders.order')</th>
                                                <th>@lang('myaccount.orders.date')</th>
                                                <th>@lang('myaccount.orders.status')</th>
                                                <th>@lang('myaccount.orders.total')</th>
                                                <th>@lang('myaccount.orders.actions')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order as $v)
                                                <tr>
                                                    <td>{{ $v->order_no }}</td>
                                                    <td>{{ date('F d, Y', strtotime($v->created_at)) }}</td>
                                                    <td>
                                                        @if ($v->dstatus == 0)
                                                            <span class="status pending">@lang('myaccount.orders.pending')</span>
                                                        @elseif($v->dstatus == 1)
                                                            <span class="status complete">@lang('myaccount.orders.confirmed')</span>
                                                        @elseif($v->dstatus == 2)
                                                            <span class="status delivered">@lang('myaccount.orders.delivered')</span>
                                                        @elseif($v->dstatus == 3)
                                                            <span class="status delivered">@lang('myaccount.orders.canceled')</span>
                                                        @else
                                                            <span class="status dispatched">@lang('myaccount.orders.dispatched')</span>
                                                        @endif
                                                    </td>
                                                    <td><span
                                                            class="icon-aed">{{ getSetting('currency') }}</span>{{ $v->amount }}
                                                    </td>
                                                    <td>
                                                        <button class="action-btn view">
                                                            <a
                                                                href="{{ url('/') }}/order_detail/{{ $v->encrypted_order_no }}">@lang('myaccount.orders.view')</a>
                                                        </button>
                                                        <button class="action-btn reorder"
                                                            style="background-color: #28a745; margin-left: 5px;">
                                                            <a href="{{ url('/') }}/reorder/{{ $v->encrypted_order_no }}"
                                                                style="color: white;">@lang('myaccount.orders.reorder')</a>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>

                        <div class="tab" id="address">
                            <h3 class="tab-name">@lang('myaccount.address.title')</h3>
                            <div class="main-content">
                                <div class="info  address-form">
                                    @foreach ($user as $v)
                                        <form action="/user_update" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $v->id }}">
                                            <div class="row" style="row-gap: 20px">
                                                <div class="col-12 col-md-6 grid-column form-grid">
                                                    <h3 class="title">@lang('myaccount.contact_info.title')</h3>
                                                    <div class="hr-line"></div>
                                                    <div class="field">
                                                        <label for="first-name">@lang('myaccount.contact_info.name')<span>*</span></label>
                                                        <input type="text" id="last-name" name="name"
                                                            value="{{ $v->name }}" required />
                                                    </div>
                                                    <div class="field">
                                                        <label for="Company-name">@lang('myaccount.contact_info.company') (optional)</label>
                                                        <input type="text" name="company" value="{{ $v->company }}"
                                                            id="Company-name" />
                                                    </div>
                                                    <div class="field">
                                                        <label for="phone">@lang('myaccount.contact_info.phone')<span>*</span></label>
                                                        <input type="phone" id="phone" name="phone"
                                                            value="{{ $v->phone }}" required />
                                                    </div>
                                                    <div class="field">
                                                        <label for="email">@lang('myaccount.contact_info.email')<span>*</span></label>
                                                        <input type="email" id="email" name="email"
                                                            value="{{ $v->email }}" required />
                                                    </div>

                                                </div>
                                                <div class=" col-12 col-md-6 grid-column form-grid">
                                                    <h3 class="title">@lang('myaccount.address.title')</h3>
                                                    <div class="hr-line"></div>
                                                    <div class="field">
                                                        <label for="address">@lang('myaccount.address.street')<span>*</span></label>
                                                        <input type="text" id="address" name="address"
                                                            value="{{ $v->address }}" required />
                                                    </div>
                                                    <div class="field">
                                                        <label for="city">@lang('myaccount.address.city')<span>*</span></label>
                                                        <input type="text" id="city" name="city"
                                                            value="{{ $v->city }}" required />
                                                    </div>
                                                    <div class="field">
                                                        <label for="unit_number">@lang('myaccount.address.unit_number')<span>*</span></label>
                                                        <input type="text" id="unit_number" name="unit_number"
                                                            value="{{ $v->unit_number }}" required />
                                                    </div>
                                                    <div class="field">
                                                        <label for="postal_code">@lang('myaccount.address.postal_code')<span>*</span></label>
                                                        <input type="text" id="postal_code" name="postal_code"
                                                            value="{{ $v->postal_code }}" required />
                                                    </div>
                                                    <div class="field">
                                                        <label for="country">@lang('myaccount.address.country')<span>*</span></label>
                                                        <select id="country-select" name="country">
                                                            <option value="" disabled selected>@lang('myaccount.address.select_country')
                                                            </option>
                                                            @foreach ($countries as $country)
                                                                <option
                                                                    {{ $v->country == $country->name ? 'selected' : '' }}
                                                                    value="{{ $country->name }}">
                                                                    {{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                            <button class="address-btn">@lang('myaccount.address.save_address')</button>
                                        </form>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="tab" id="payment-methods">
                            <h3 class="tab-name">@lang('myaccount.payment_methods.title')</h3>
                            <div class="main-content">
                                <div class="info active-address payment-info">
                                    <div class="no-payment-methods">
                                        <p>@lang('myaccount.payment_methods.no_methods')</p>
                                        <button class="address-btn " id="payment-btn">@lang('myaccount.payment_methods.add')</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab" id="account-details">
                            <h3 class="tab-name">@lang('myaccount.account_details.title')</h3>
                            <div class="main-content">
                                <div class="info  address-form">
                                    @foreach ($user as $v)
                                        <form action="/user_update" method="post">
                                            @csrf
                                            <input type="hidden" value="{{ $v->id }}" name="id">
                                            <div class="row">
                                                <div class="col grid-column form-grid">
                                                    <div class="field">
                                                        <label for="first-name">@lang('myaccount.account_details.name')<span>*</span></label>
                                                        <input type="text" id="last-name" name="name"
                                                            value="{{ $v->name }}" required />
                                                    </div>
                                                    <div class="field">
                                                        <label for="display-name">@lang('myaccount.account_details.display_name') <span>*</span></label>
                                                        <input type="text" id="display-name" readonly
                                                            value="{{ $v->name }}" required />
                                                    </div>
                                                    <div class="field">
                                                        <label for="email">@lang('myaccount.account_details.email')<span>*</span></label>
                                                        <input type="email" id="email" name="email"
                                                            value="{{ $v->email }}" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="address-btn">@lang('myaccount.account_details.save_changes')</button>
                                        </form>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="tab" id="logout">
                            <h3 class="tab-name">@lang('myaccount.logout.title')</h3>
                            <p>@lang('myaccount.logout.subtitle')</p>
                            <a href="{{ url('/') }}/logout" class="btn btn-danger"> <button>
                                    @lang('myaccount.logout.button')</button> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('') }}front/Dasboard.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <script src="{{ asset('') }}front/script.js"></script>
    <script>
        $(document).ready(function() {
            $('#order-table').DataTable({
                "order": [], // Disable initial sort since backend handles it (latest first)
                "pageLength": 10,
                "responsive": true
            });
        });
    </script>
@endsection
