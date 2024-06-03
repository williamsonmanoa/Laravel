<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CoureurRequest;
use App\Models\Equipe;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CoureurCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CoureurCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Coureur::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/coureur');
        CRUD::setEntityNameStrings('coureur', 'coureurs');

        $this->crud->addColumns([
            [
                'label' => "Equipe",
                'type' => 'select',
                'name' => 'equipe_id',
                'entity' => 'equipe',
                'attribute' => 'nom',
                'model' => Equipe::class
            ],
            [   // SelectMultiple = n-n relationship (with pivot table)
                'label'     => "Categorie",
                'type'      => 'select_multiple',
                'name'      => 'categories', // the method that defines the relationship in your Model

                // optional
                'entity'    => 'categories', // the method that defines the relationship in your Model
                'model'     => "App\Models\Category", // foreign key model
                'attribute' => 'nom', // foreign key attribute that is shown to user
                'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?

                // also optional
                'options'   => (function ($query) {
                    return $query->orderBy('nom', 'ASC')->get();
                }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
            ],
            [
                'name'  => 'genre',
                'label' => 'Genre',
                'type'  => 'enum',
                // optional, specify the enum options with custom display values
                'options' => [
                    'M' => 'Homme',
                    'F' => 'Femme'
                ]
            ]
        ]);


        // fields
        $this->crud->addFields([
            [
                'label' => "Equipe",
                'type' => 'select',
                'name' => 'equipe_id',
                'entity' => 'equipe',
                'attribute' => 'nom',
                'model' => Equipe::class
            ],
            [   // SelectMultiple = n-n relationship (with pivot table)
                'label'     => "Categorie",
                'type'      => 'select_multiple',
                'name'      => 'categories', // the method that defines the relationship in your Model

                // optional
                'entity'    => 'categories', // the method that defines the relationship in your Model
                'model'     => "App\Models\Category", // foreign key model
                'attribute' => 'nom', // foreign key attribute that is shown to user
                'pivot'     => true, // on create&update, do you need to add/delete pivot table entries?

                // also optional
                'options'   => (function ($query) {
                    return $query->orderBy('nom', 'ASC')->get();
                }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
            ],
            [
                'name'  => 'genre',
                'label' => 'Genre',
                'type'  => 'enum',
                // optional, specify the enum options with custom display values
                'options' => [
                    'M' => 'Homme',
                    'F' => 'Femme'
                ]
            ]
        ]);
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
        CRUD::setValidation(CoureurRequest::class);
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
}
