@if ($crud->hasAccess('create'))
    <div class="card">
        <form method="post" enctype="multipart/form-data" class="row g-3" action="{{url($crud->route.'/import_csv')}}">
            @csrf
            <div class="col-auto">
                <input type="file"  class="form-control" name="file" accept="text/csv" required/>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3"><span class="ladda-label"><i class="la la-plus"></i></span> Importer fichier CSV</button>
            </div>
        </form>
    </div>
@endif

{{--@push('after_scripts')--}}
{{--    <script>--}}
{{--        if (typeof importTransaction != 'function') {--}}
{{--            $("[data-button-type=import]").unbind('click');--}}

{{--            function importTransaction(button) {--}}
{{--                // ask for confirmation before deleting an item--}}
{{--                // e.preventDefault();--}}
{{--                var button = $(button);--}}
{{--                var route = button.attr('data-route');--}}

{{--                $.ajax({--}}
{{--                    url: route,--}}
{{--                    type: 'POST',--}}
{{--                    success: function(result) {--}}
{{--                        // Show an alert with the result--}}
{{--                        console.log(result,route);--}}
{{--                        new Noty({--}}
{{--                            text: "Some Tx had been imported",--}}
{{--                            type: "success"--}}
{{--                        }).show();--}}

{{--                        // Hide the modal, if any--}}
{{--                        $('.modal').modal('hide');--}}

{{--                        crud.table.ajax.reload();--}}
{{--                    },--}}
{{--                    error: function(result) {--}}
{{--                        // Show an alert with the result--}}
{{--                        new Noty({--}}
{{--                            text: "The new entry could not be created. Please try again.",--}}
{{--                            type: "warning"--}}
{{--                        }).show();--}}
{{--                    }--}}
{{--                });--}}
{{--            }--}}
{{--        }--}}
{{--    </script>--}}
{{--@endpush--}}
