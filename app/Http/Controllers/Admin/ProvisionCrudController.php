<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProvisionRequest;
use App\Models\Provision;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProvisionCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProvisionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Provision::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/provision');
        CRUD::setEntityNameStrings('provision', 'provisions');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     *
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

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(ProvisionRequest::class);
        //        CRUD::setFromDb(); // set fields from db columns.

        CRUD::addFields([
            [
                'label' => 'Date',
                'name' => 'date',
                'type' => 'date',
            ],
            [
                'label' => 'Amount',
                'name' => 'amount',
                'type' => 'number',
                'attributes' => ['step' => '0.01'],
            ],
            [
                'label' => 'Description',
                'name' => 'description',
                'type' => 'text',
            ],
        ]);

        Provision::creating(function ($entry) {
            $entry->user_id = backpack_user()->id;
        });
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     *
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
