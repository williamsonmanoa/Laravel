<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EtapeRequest;
use App\Models\Etape;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class EtapeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EtapeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Etape::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/etape');
        CRUD::setEntityNameStrings('etape', 'etapes');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.
        //CRUD::addButtonFromView('line', 'import_csv', 'moderate', 'beginning');
        CRUD::addButtonFromView('top', 'import_csv', 'import_csv', 'end');
        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(EtapeRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function import_csv(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv',
        ]);

        $iCountImported = 0;
        //read csv file and skip data
        $file = $request->file('file');
        $handle = fopen($file->path(), 'r');

        //skip the header row
        $head = fgetcsv($handle);

        foreach ($head as &$item){
            $item = Str::slug($item);
        }

        while($etapeCsv = fgetcsv($handle))
        {
            // This is a great trick, to get an associative row by combining the headrow with the content-rows.
            $etapeCsv = array_combine($head, $etapeCsv);

            if(
                !isset($resultatCsv['etape'])
                || !isset($resultatCsv['longueur'])
                || !isset($resultatCsv['rang'])
                || !isset($resultatCsv['nb-coureur'])
                || !isset($resultatCsv['date-depart'])
            ){
                \Alert::add('error', 'Fichier invalide')->flash();
                return redirect(backpack_url('etape'));
            }

            $etape = Etape::where('rang_etape','=',$etapeCsv['rang'])->first();

            $dateDepart = new Carbon($etapeCsv['date-depart'] . ' ' . $etapeCsv['heure-depart']);

            $dataEtape = [
                'nom' => $etapeCsv['etape'],
                'longeur' => (float)$etapeCsv['longueur'],
                'rang_etape' => (int)$etapeCsv['rang'],
                'nb_coureurs' => (int)$etapeCsv['nb-coureur'],
                'date_heure_depart' => $dateDepart->format('Y-m-d H:i:s'),
            ];

            if(!$etape){
                Etape::create($dataEtape);
            }else{
                $etape->update($dataEtape);
            }

            $iCountImported++;
        }
        fclose($handle);

        \Alert::add('success', 'Import des étapes réussi. ' . $iCountImported . ' ligne(s) importée(s)')->flash();
        return redirect(backpack_url('etape'));
    }
}
