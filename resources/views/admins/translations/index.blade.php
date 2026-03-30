@extends('admins.master')

@section('title', 'Translations - ' . $language->name)
@section('languages_active', 'active')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">

        {{-- Actions Row: Add Key + Import JSON (keep your existing forms if you like) --}}
        <div class="row">
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Add Translation Key</h5>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" method="post"
                            action="{{ route('admins.translations.addkey', $language->code) }}">
                            @csrf
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Key</label>
                                <div class="col-lg-9">
                                    <input type="text" required name="key" class="form-control"
                                        placeholder="e.g. home.title">
                                    @error('key')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>
                            <div class="form-group"><label class="col-lg-3 control-label">English (default)
                                    value</label>
                                <div class="col-lg-9">
                                    <textarea name="default_value" class="form-control" rows="2" placeholder="Optional: English reference text"></textarea>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-lg-3 control-label"></label>
                                <div class="col-lg-9"><button class="btn btn-sm btn-primary" type="submit"><strong>Add
                                            Key</strong></button></div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Import JSON ({{ $language->code }})</h5>
                    </div>
                    <div class="ibox-content">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data"
                            action="{{ route('admins.translations.importjson', $language->code) }}">
                            @csrf
                            <div class="form-group">
                                <label class="col-lg-3 control-label">JSON File</label>
                                <div class="col-lg-9">
                                    <input type="file" accept=".json,application/json,text/plain" name="json_file"
                                        required>
                                    @error('json_file')
                                        <span class="help-block m-b-none text-danger">{{ $message }}</span>
                                    @enderror
                                    <p class="help-block m-b-none">Import format matches your sample JSON.</p>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-lg-3 control-label"></label>
                                <div class="col-lg-9"><button class="btn btn-sm btn-primary"
                                        type="submit"><strong>Import</strong></button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- DataTable --}}
        <table id="translationsTable" class="table table-striped table-bordered table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Sr.No</th>
                    <th>Key (read-only)</th>
                    <th>English (default)</th> <!-- NEW read-only reference -->
                    <th>Value ({{ $language->code }})</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>


        <hr>
        <h4>Sample JSON</h4>
        <pre>
            {
              "home.title": "Welcome" ,
              "home.cta": "Shop Now"
            }
      </pre>
    </div>
    </div>
    </div>
    </div>
    </div>
@endsection

@push('scripts')
    {{-- Make sure jquery + DataTables js/css are included in your master --}}
    <script>
        (function() {
            const CSRF = '{{ csrf_token() }}';
            const LANG = '{{ $language->code }}';
            const DT_URL = '{{ route('admins.translations.datatable', $language->code) }}';
            const SAVE_URL = '{{ route('admins.translations.savevalue', $language->code) }}';
            const DELETE_URL = (id) => '{{ url('admin/translation/') }}/' + id;

            // Init DataTable
            const table = $('#translationsTable').DataTable({
                processing: true,
                serverSide: true,
                deferRender: true,
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                ajax: {
                    url: DT_URL,
                    type: 'GET'
                },
                order: [
                    [1, 'asc']
                ], // order by key
                columns: [{
                        data: 'srno',
                        name: 'srno',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'key',
                        name: 'key',
                        width: '285px',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'default_en',
                        name: 'default_en',
                        width: '285px',
                        orderable: true,
                        searchable: true
                    }, // NEW
                    {
                        data: 'value',
                        name: 'value',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Debounce helper
            function debounce(fn, wait = 600) {
                let t;
                return function(...args) {
                    clearTimeout(t);
                    t = setTimeout(() => fn.apply(this, args), wait);
                }
            }

            // Inline autosave on input
            const debouncedSave = debounce(function(ta) {
                inlineSave(ta);
            }, 600);

            // Delegate input events (works across redraws)
            $('#translationsTable tbody').on('input', 'textarea.js-translation-input', function() {
                debouncedSave(this);
            });

            // Save on blur too
            $('#translationsTable tbody').on('blur', 'textarea.js-translation-input', function() {
                inlineSave(this);
            });

            // Per-row Save button
            $('#translationsTable tbody').on('click', '.js-save-one', function() {
                const row = $(this).closest('tr');
                const ta = row.find('textarea.js-translation-input')[0];
                inlineSave(ta);
            });

            // Delete key
            $('#translationsTable tbody').on('click', '.js-delete-key', function() {
                const id = $(this).data('key-id');
                if (!confirm('Delete this key across all languages?')) return;
                fetch(DELETE_URL(id), {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': CSRF,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    }).then(r => r.json())
                    .then(j => {
                        if (j && j.ok) {
                            toast('Key deleted');
                            table.ajax.reload(null, false);
                        } else toast('Delete failed', 'error');
                    }).catch(() => toast('Delete failed', 'error'));
            });

            function inlineSave(taEl) {
                const $ta = $(taEl);
                const id = $ta.data('key-id');
                const val = $ta.val();
                const status = $ta.closest('td').find('.js-inline-status');
                status.text('Saving...').show();

                fetch(SAVE_URL, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': CSRF,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            translation_key_id: id,
                            value: val
                        })
                    })
                    .then(r => r.json())
                    .then(j => {
                        if (j && j.ok) {
                            status.text('Saved');
                            setTimeout(() => status.hide(), 800);
                        } else {
                            status.text('Error');
                            toast('Save failed', 'error');
                        }
                    })
                    .catch(() => {
                        status.text('Error');
                        toast('Save failed', 'error');
                    });
            }

            // Tiny toast
            function toast(msg, type = 'success') {
                const el = document.createElement('div');
                el.className = 'ibox';
                el.style.cssText = 'position:fixed;right:20px;bottom:20px;z-index:9999;padding:10px 14px;background:' +
                    (type === 'error' ? '#ed5565' : '#1ab394') + ';color:#fff;border-radius:4px;';
                el.textContent = msg;
                document.body.appendChild(el);
                setTimeout(() => el.remove(), 1500);
            }
        })();
    </script>
@endpush
