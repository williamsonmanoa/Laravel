<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ResultatRequest;
use App\Models\Coureur;
use App\Models\Equipe;
use App\Models\Etape;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ResultatCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ResultatCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }

    private function isEquipe()
    {
        return backpack_auth()->user() && backpack_auth()->user()->hasRole('admin-equipe');
    }

    private function getEquipe()
    {
        return backpack_auth()->user()->equipe;
    }
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Resultat::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/resultat');
        CRUD::setEntityNameStrings('resultat', 'resultats');

        if( $this->isEquipe() ){
            $this->crud->removeField('equipe_id');
        }

        $listFields = [
            [
                'label' => "Coureur",
                'type' => 'select',
                'name' => 'coureur_id',
                'entity' => 'coureur',
                'attribute' => 'nom',
                'model' => Coureur::class
            ],
            [
                'label' => "Etape",
                'type' => 'select',
                'name' => 'etape_id',
                'entity' => 'etape',
                'attribute' => 'nom',
                'model' => Etape::class
            ]
        ];
        if( !$this->isEquipe() ){
            $listFields[] = [
                'label' => "Equipe",
                'type' => 'select',
                'name' => 'equipe_id',
                'entity' => 'equipe',
                'attribute' => 'nom',
                'model' => Equipe::class
            ];
        }

        $this->crud->addFields($listFields);
        $this->crud->addColumns($listFields);
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

        if( $this->isEquipe() ){
            $this->crud->removeColumn('equipe_id');
        }
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
        CRUD::setValidation([
            // 'name' => 'required|min:2',
        ]);
        CRUD::setFromDb(); // set fields from db columns.

        if( $this->isEquipe() ){
            $this->crud->removeField('equipe_id');
        }
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

    public function update()
    {
        if( !request()->get('password') ){
            $this->crud->removeField('password');
        }
        $response = $this->traitUpdate();

        if( $this->isEquipe() ){
            $resultat = $this->crud->getEntry(0);

            if( $resultat ){
                $resultat->update([
                    'equipe_id' => $this->getEquipe()->id
                ]);
            }
        }
        // do something after save
        return $response;
    }


    public function store()
    {
        // do something before validation, before save, before everything; for example:
        // $this->crud->addField(['type' => 'hidden', 'name' => 'author_id']);
        // $this->crud->removeField('password_confirmation');

        // Note: By default Backpack ONLY saves the inputs that were added on page using Backpack fields.
        // This is done by stripping the request of all inputs that do NOT match Backpack fields for this
        // particular operation. This is an added security layer, to protect your database from malicious
        // users who could theoretically add inputs using DeveloperTools or JavaScript. If you're not properly
        // using $guarded or $fillable on your model, malicious inputs could get you into trouble.

        // However, if you know you have proper $guarded or $fillable on your model, and you want to manipulate
        // the request directly to add or remove request parameters, you can also do that.
        // We have a config value you can set, either inside your operation in `config/backpack/crud.php` if
        // you want it to apply to all CRUDs, or inside a particular CrudController:
        // $this->crud->setOperationSetting('saveAllInputsExcept', ['_token', '_method', 'http_referrer', 'current_tab', 'save_action']);
        // The above will make Backpack store all inputs EXCEPT for the ones it uses for various features.
        // So you can manipulate the request and add any request variable you'd like.
        // $this->crud->getRequest()->request->add(['author_id'=> backpack_user()->id]);
        // $this->crud->getRequest()->request->remove('password_confirmation');
        $response = $this->traitStore();

        if( $this->isEquipe() ){
            $resultat = $this->crud->getEntry(0);
            if( $resultat ){
                $resultat->update([
                    'equipe_id' => $this->getEquipe()->id
                ]);
            }
        }
        // do something after save
        return $response;
    }
}
