@if ($crud->hasAccess('create') && backpack_auth()->user()->hasRole('root') )
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
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
            </div>
        </div>

    </div>
@endif
