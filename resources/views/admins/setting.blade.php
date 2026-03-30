@extends('admins.master')
<style>
    label {
        text-align: left !important;
    }

    .bootstrap-tagsinput {
        width: 100% !important;
    }
</style>
@php
    use App\Models\Currency;
    use App\Models\Vat;
@endphp
@section('title', 'Setting')

@section('setting', 'active')


@section('content')
    <div class=" setting_container ">
        <ul class="settings_tabs">
            <li class="active tab-btn" onclick="showPanel('general')">general setting</li>
            <li class="tab-btn" onclick="showPanel('payment')"> payment configuration </li>
            <li class="tab-btn" onclick="showPanel('shipping')"> Shipping Methods </li>
        </ul>
        <div class="right_panel active" id="general-panel">
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Setting Form</h5>
                            </div>
                            <div class="ibox-content">
                                <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group"><label class="col-sm-12 control-label">Site Title:</label>
                                        <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->site_title) ? htmlspecialchars($edit->site_title) : null; ?>" required
                                                class="form-control" name="site_title"></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-12 control-label">Seo Title:</label>
                                        <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->title) ? htmlspecialchars($edit->title) : null; ?>" required
                                                class="form-control" name="title"></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-12 control-label">Seo Description:</label>
                                        <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->description) ? htmlspecialchars($edit->description) : null; ?>" required
                                                class="form-control" name="description"></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-12 control-label">Seo Keyword:</label>
                                        <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->keywords) ? htmlspecialchars($edit->keywords) : null; ?>" required
                                                class="form-control" name="keywords"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">Favicon:</label>
                                        <!--<input type="file" require  accept="image/png, image/gif, image/jpeg" class="form-control" <?php echo isset($edit->video_link) ? 'required' : ''; ?>   name="logo">-->
                                        <div class="col-sm-12"><input type="file" onchange="readURL(this);"
                                                <?php echo isset($edit->id) ? null : 'required'; ?> accept="image/png, image/gif, image/jpeg"
                                                class="form-control" name="logo1">
                                            <img src="<?php echo isset($edit->logo1) ? asset($edit->logo1) : null; ?>" alt="" <?php echo $edit->logo1 != null ? 'style="width:100px;"' : 'style="display:none;width:100px;"'; ?>>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">Header Logo:</label>
                                        <!--<input type="file" require  accept="image/png, image/gif, image/jpeg" class="form-control" <?php echo isset($edit->video_link) ? 'required' : ''; ?>   name="logo">-->
                                        <div class="col-sm-12"><input type="file" onchange="readURL(this);"
                                                <?php echo isset($edit->id) ? null : 'required'; ?> accept="image/png, image/gif, image/jpeg"
                                                class="form-control" name="logo">
                                            <img src="<?php echo isset($edit->logo) ? asset($edit->logo) : null; ?>" alt="" <?php echo $edit->logo != null ? 'style="width:100px;"' : 'style="display:none;width:100px;"'; ?>>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-12 control-label">Email:</label>
                                        <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->email) ? htmlspecialchars($edit->email) : null; ?>"
                                                required class="form-control" name="email"></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-12 control-label">Phone Number:</label>
                                        <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->phone) ? htmlspecialchars($edit->phone) : null; ?>"
                                                required class="form-control" name="phone"></div>
                                    </div>

                                    <div class="form-group"><label class="col-sm-12 control-label">Second Phone
                                            Number:</label>
                                        <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->phonetwo) ? htmlspecialchars($edit->phonetwo) : null; ?>"
                                                required class="form-control" name="phonetwo"></div>
                                    </div>

                                    <div class="form-group"><label class="col-sm-12 control-label">Instagram Link:</label>
                                        <div class="col-sm-12"><input type="text" value="<?php echo isset($edit->instagram) ? htmlspecialchars($edit->instagram) : null; ?>"
                                                required class="form-control" name="instagram"></div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-12 control-label">Footer Text:</label>
                                        <div class="col-sm-12">
                                            <textarea class="summernote" name="homepage_footer" rows="5">
                                                <?php echo isset($edit->homepage_footer) ? htmlspecialchars($edit->homepage_footer) : null; ?>
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-12 control-label">Address:</label>
                                        <div class="col-sm-12">
                                            <textarea class="summernote" name="footer" rows="5">
                                                <?php echo isset($edit->footer_text) ? htmlspecialchars($edit->footer_text) : null; ?>
                                            </textarea>
                                        </div>
                                    </div>
                                    <h1>Shipping</h1>
                                    <div class="form-group"><label class="col-sm-12 control-label">Shipping:</label>
                                        <div class="col-sm-12">
                                            <input type="text" name="shipping" class="form-control"
                                                value="<?php echo isset($edit->shipping) ? $edit->shipping : null; ?>">

                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-12 control-label">Shipping Time:</label>
                                        <div class="col-sm-12">
                                            <input type="text" name="shipping_time" class="form-control"
                                                value="<?php echo isset($edit->shipping_time) ? $edit->shipping_time : null; ?>">

                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-12 control-label">Min Order Value:</label>
                                        <div class="col-sm-12">
                                            <input type="text" name="min_order_value" class="form-control"
                                                value="<?php echo isset($edit->min_order_value) ? $edit->min_order_value : null; ?>">

                                        </div>
                                    </div>
                                    <h1>Tax</h1>
                                    <div class="form-group"><label class="col-sm-12 control-label">Tax:</label>
                                        <div class="col-sm-12">
                                            <select name="tax_value" id="" class="form-control">
                                                @php
                                                    $vats = Vat::all();
                                                @endphp
                                                <option value="">Select Tax</option>
                                                @if ($vats)
                                                    @foreach ($vats as $vat)
                                                        <option value="{{ $vat->id }}"
                                                            {{ isset($edit->tax_value) && $edit->tax_id == $vat->id ? 'selected' : '' }}>
                                                            {{ $vat->country_name }} ({{ $vat->tax_value }} %)</option>
                                                    @endforeach
                                                @endif

                                            </select>
                                        </div>
                                    </div>
                                    <h1>Currency</h1>
                                    <div class="form-group"><label class="col-sm-12 control-label">Currency:</label>
                                        <div class="col-sm-12">
                                            <select name="currency" id="" class="form-control">
                                                @php
                                                    $currencies = Currency::all();
                                                @endphp
                                                <option value="">Select Currency</option>
                                                @if ($currencies)
                                                    @foreach ($currencies as $currency)
                                                        <option value="{{ $currency->symbol }}"
                                                            {{ isset($edit->currency) && $edit->currency == $currency->symbol ? 'selected' : '' }}>
                                                            {{ $currency->name }}</option>
                                                    @endforeach
                                                @endif

                                            </select>
                                        </div>
                                    </div>

                                    <h1>Stripe</h1>
                                    <div class="form-group"><label class="col-sm-12 control-label">Public Key:</label>
                                        <div class="col-sm-12">
                                            <input type="text" name="stripe_public_key" class="form-control"
                                                value="<?php echo isset($edit->stripe_public_key) ? $edit->stripe_public_key : null; ?>">

                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-12 control-label">Secret Key:</label>
                                        <div class="col-sm-12">
                                            <input type="text" name="stripe_secret_key" class="form-control"
                                                value="<?php echo isset($edit->stripe_secret_key) ? $edit->stripe_secret_key : null; ?>">
                                        </div>
                                    </div>
                                    <h1>SMTP Setting</h1>
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">SMTP Host:</label>
                                        <div class="col-sm-12">
                                            <input type="text" name="smtp_host" class="form-control"
                                                value="<?php echo isset($edit->smtp_host) ? $edit->smtp_host : ''; ?>"
                                                placeholder="SMTP server (e.g., smtp.gmail.com)">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">SMTP Port:</label>
                                        <div class="col-sm-12">
                                            <input type="number" name="smtp_port" class="form-control"
                                                value="<?php echo isset($edit->smtp_port) ? $edit->smtp_port : ''; ?>" placeholder="SMTP Port (e.g., 587)">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">SMTP Username:</label>
                                        <div class="col-sm-12">
                                            <input type="text" name="smtp_username" class="form-control"
                                                value="<?php echo isset($edit->smtp_username) ? $edit->smtp_username : ''; ?>" placeholder="SMTP Username">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">SMTP Password:</label>
                                        <div class="col-sm-12">
                                            <input type="password" name="smtp_password" class="form-control"
                                                value="<?php echo isset($edit->smtp_password) ? $edit->smtp_password : ''; ?>" placeholder="SMTP Password">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">Encryption Type:</label>
                                        <div class="col-sm-12">
                                            <select name="smtp_encryption" class="form-control">
                                                <option value="tls" <?php echo isset($edit->smtp_encryption) && $edit->smtp_encryption == 'tls' ? 'selected' : ''; ?>>TLS</option>
                                                <option value="ssl" <?php echo isset($edit->smtp_encryption) && $edit->smtp_encryption == 'ssl' ? 'selected' : ''; ?>>SSL</option>
                                                <option value="none" <?php echo isset($edit->smtp_encryption) && $edit->smtp_encryption == 'none' ? 'selected' : ''; ?>>None</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">Sender Email Address:</label>
                                        <div class="col-sm-12">
                                            <input type="email" name="smtp_from_email" class="form-control"
                                                value="<?php echo isset($edit->smtp_from_email) ? $edit->smtp_from_email : ''; ?>"
                                                placeholder="Email address from which emails will be sent">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-12 control-label">Sender Name:</label>
                                        <div class="col-sm-12">
                                            <input type="text" name="smtp_from_name" class="form-control"
                                                value="<?php echo isset($edit->smtp_from_name) ? $edit->smtp_from_name : ''; ?>"
                                                placeholder="Name from which emails will appear">
                                        </div>
                                    </div>



                                    @if (isset($edit->id))
                                        <input type="hidden" name="hidden_id" value="{{ $edit->id }}">
                                    @endif
                                    <div class="form-group">
                                        <div class="col-sm-10"><button class="btn btn-md btn-primary"
                                                type="submit"><strong>Save</strong></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="payment-panel" class="right_panel">
            <form class="payment_form">
                <!-- Payment options -->
                <div class="payment_tabs">
                    <div class="payment_tab active" data-payment="Ngenius">Credit/Debit Card</div>
                    <div class="payment_tab" data-payment="Stripe">Stripe</div>
                    <div class="payment_tab" data-payment="Cod">Cash on Delivery</div>
                    <div class="payment_tab" data-payment="Google Pay">Google Pay</div>
                    <div class="payment_tab" data-payment="Apple Pay">Apple Pay</div>
                </div>

                <!-- Dynamic form content -->
                <div class="payment_form_content">
                    <!-- Title -->
                    <h3 id="form-title">Credit/Debit Card Payment</h3>

                    <!-- Enable/Disable switch -->
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" value="1" id="enableSwitch" />
                        <label class="form-check-label" for="enableSwitch">
                            Enable Option
                        </label>
                    </div>

                    <!-- Additional Input for Payment Details -->
                    <input type="text" id="details-input" placeholder="Enter payment details (if required)" />

                    <!-- Submit button -->
                    <button type="button" id="submit-button">Save</button>
                </div>
            </form>
        </div>
        <div class="right_panel" id="shipping-panel">
            <div class="payment_form" style="padding: 20px;">
                <h3>Shipping Methods</h3>
                <ul id="shipping-list"></ul>
            
                <input type="text" class="form-control" id="shipping-name" placeholder="Enter shipping method name" />
                <label>
                    <input type="checkbox" id="default-method" /> Set as Default
                </label>
                <br>
                <button id="add-shipping">Add Shipping Method</button>
            </div>
            
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    loadShippingMethods();
            
                    document.getElementById("add-shipping").addEventListener("click", function () {
                        let name = document.getElementById("shipping-name").value;
                        let isDefault = document.getElementById("default-method").checked;
                        
                        fetch("{{url('/admin/shipping-methods')}}", {
                            method: "POST",
                            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                            body: JSON.stringify({ name: name, is_default: isDefault })
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.message);
                            document.getElementById("default-method").checked = false;
                            loadShippingMethods();
                        });
                    });
                });
            
                function loadShippingMethods() {
                    fetch("/admin/shipping-methods")
                        .then(response => response.json())
                        .then(data => {
                            let list = document.getElementById("shipping-list");
                            list.innerHTML = "";
                            data.forEach(method => {
                                let li = document.createElement("li");
                                li.innerHTML = `
                                    ${method.name}
                                    <label class="switch">
                                        <input type="checkbox" onchange="toggleDefault(${method.id})" ${method.is_default ? "checked" : ""}>
                                        <span class="slider round"></span>
                                    </label>
                                    <button onclick="editShipping(${method.id}, '${method.name}')">Edit</button>
                                    <button onclick="deleteShipping(${method.id})" ${method.is_default ? "disabled" : ""}>Delete</button>
                                `;
                                list.appendChild(li);
                            });
                        });
                }
            
                function toggleDefault(id) {
                    fetch(`/admin/shipping-methods/${id}`, {
                        method: "PUT",
                        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                        body: JSON.stringify({ is_default: true })
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        loadShippingMethods();
                    });
                }
            
                function editShipping(id, name) {
                    let newName = prompt("Edit Shipping Method:", name);
                    if (newName) {
                        fetch(`/admin/shipping-methods/${id}`, {
                            method: "PUT",
                            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                            body: JSON.stringify({ name: newName })
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.message);
                            loadShippingMethods();
                        });
                    }
                }
            
                function deleteShipping(id) {
                    if (!confirm("Are you sure you want to delete this method?")) return;
            
                    fetch(`/admin/shipping-methods/${id}`, {
                        method: "DELETE",
                        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
                    })
                    .then(response => {
                        if (response.ok) return response.json();
                        throw new Error("Cannot delete the default shipping method!");
                    })
                    .then(data => {
                        alert(data.message);
                        loadShippingMethods();
                    })
                    .catch(error => alert(error.message));
                }
            </script>
            
            <style>
                /* Toggle Switch Styles */
                .switch {
                    position: relative;
                    display: inline-block;
                    width: 34px;
                    height: 20px;
                }
            
                .switch input {
                    opacity: 0;
                    width: 0;
                    height: 0;
                }
            
                .slider {
                    position: absolute;
                    cursor: pointer;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background-color: #ccc;
                    transition: 0.4s;
                    border-radius: 20px;
                }
            
                .slider:before {
                    position: absolute;
                    content: "";
                    height: 14px;
                    width: 14px;
                    left: 3px;
                    bottom: 3px;
                    background-color: white;
                    transition: 0.4s;
                    border-radius: 50%;
                }
            
                input:checked + .slider {
                    background-color: #2196F3;
                }
            
                input:checked + .slider:before {
                    transform: translateX(14px);
                }
            </style>
            
            
            
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $(input).parent().find('img').attr('src', e.target.result).show();
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.payment_tab');
            const formTitle = document.getElementById('form-title');
            const enableSwitch = document.getElementById('enableSwitch');
            const detailsInput = document.getElementById('details-input');
            const submitButton = document.getElementById('submit-button');

            let currentPaymentMethod = 'Ngenius'; // Default payment method

            // Function to load existing data for the selected payment method
            function loadPaymentMethodData(paymentMethod) {
                fetch(`/admin/get-payment-settings/${paymentMethod}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Fetched Payment Data:', data); // Debugging response
                        formTitle.textContent = `${data.method_name || paymentMethod} Payment`;
                        enableSwitch.checked = data.is_enabled == 1; // Explicit comparison to ensure accuracy
                        detailsInput.value = data.details || '';
                    })
                    .catch(error => console.error('Error fetching payment settings:', error));
            }

            // Load data for the default payment method on page load
            loadPaymentMethodData(currentPaymentMethod);

            // Switch tabs and load data for the selected payment method
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs
                    tabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    // Update the current payment method
                    currentPaymentMethod = this.dataset.payment;

                    // Load data for the selected payment method
                    loadPaymentMethodData(currentPaymentMethod);
                });
            });

            // Save updated data to the server
            submitButton.addEventListener('click', function() {
                const isEnabled = enableSwitch.checked ? 1 : 0;
                const details = detailsInput.value;

                fetch('/admin/save-payment-settings', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        },
                        body: JSON.stringify({
                            payment_method: currentPaymentMethod,
                            enabled: isEnabled,
                            details: details,
                        }),
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Save Response:', data); // Debugging response
                        if (data.success) {
                            alert('Settings saved successfully!');
                        } else {
                            alert('Failed to save settings.');
                        }
                    })
                    .catch(error => console.error('Error saving payment settings:', error));
            });
        });



        function showPanel(panelId) {
            // Hide all panels
            document.querySelectorAll('.right_panel').forEach(panel => {
                panel.classList.remove('active');
            });

            // Remove active class from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Show the selected panel
            document.getElementById(`${panelId}-panel`).classList.add('active');

            // Highlight the active button
            document.querySelector(`.tab-btn[onclick="showPanel('${panelId}')"]`).classList.add('active');
        }
    </script>
@endpush
