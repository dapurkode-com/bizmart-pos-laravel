@extends('adminlte::page')

@section('title', 'Cash Count')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <blockquote style="margin: 0; background: unset;">
                <h1 class="m-0 text-dark">Hitung Kas</h1>
            </blockquote>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Hitung Kas</li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <!-- main content -->
    <div class="row mainContent">
        <div class="col-sm-12">
            <div class="card bg-default">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i> Tambah Hitung Kas</h5>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" class="btn btn-default" data-card-widget="collapse" title="Toggle Table"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Saldo Hitung</label>
                                <input type="number" name="counted_amount" class="form-control" placeholder="Tulis saldo terhitung saat ini"/>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Oleh</label>
                                <input type="text" value="{{ auth()->user()->name }}" class="form-control" disabled/>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer justify-content-between">
                    <button type="reset" class="myReset btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        [type="submit"] {
            float: right;
        }
    </style>
@stop

@section('js')
    <script type="module">
        import { domReady, addListenToEvent, drawError, eraseErrorInit, swalAlert, simulateEvent } from '{{ asset("plugins/custom/global.app.js") }}'
        
        const mainContentElm = document.querySelector('.mainContent');
        const dateStartFilterInput = document.querySelector('.indexTableFilter [name="date_start"]')
        const dateEndFilterInput = document.querySelector('.indexTableFilter [name="date_end"]')
        const resetBtn = mainContentElm.querySelector('button[type="reset"]')

        domReady(() => {
            eraseErrorInit();

            addListenToEvent('.mainContent button[type="reset"]', 'click', (event) => {
                mainContentElm.querySelector('[name="counted_amount"]').value = '';
            });

            addListenToEvent('.mainContent button[type="submit"]', 'click', (event) => {
                event.preventDefault();
                const thisBtn = event.target.closest('button');

                // prepare data
                let data = {
                    counted_amount : mainContentElm.querySelector('[name="counted_amount"]').value,
                    _method : 'POST',
                }
                // end prepare data
                
                // loading and disabled button
                const thisBtnText = thisBtn.innerHTML;
                thisBtn.innerHTML = `<i class="fas fa-circle-notch fa-spin"></i> ${thisBtnText}...`
                for (const elm of mainContentElm.querySelectorAll('button')) {
                    elm.disabled = true;
                }
                
                fetch(`{{ route('cash_count.store') }}`, {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(result => {
                        if(result.status == 'invalid'){
                            drawError(mainContentElm, result.validators);
                        }
                        if(result.status == 'valid'){
                            if(result.is_selisih === true){
                                swalAlert(result.pesan, 'error');
                            } else {
                                swalAlert(result.pesan, 'success');
                            }
                        }
                        if(result.status == 'error'){
                            swalAlert(result.pesan, 'warning');
                        }
                    })
                    .finally(() => {
                        // loading and disabled button
                        thisBtn.innerHTML = `${thisBtnText}`
                        for (const elm of mainContentElm.querySelectorAll('button')) {
                            elm.disabled = false;
                        }
                        simulateEvent(resetBtn, 'click')
                    });
            });
        });

    </script>
@stop
