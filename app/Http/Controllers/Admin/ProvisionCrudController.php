<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProvisionRequest;
use App\Models\Provision;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class ProvisionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\Provision::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/provision');
        CRUD::setEntityNameStrings('provision', 'provisions');

        $this->crud->operation(['list', 'show', 'update', 'delete'], function() {
            $this->crud->addClause(fn ($query) => $query->where('user_id', backpack_user()->id));
        });
    }

    protected function setupListOperation(): void
    {
        CRUD::setFromDb();
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
