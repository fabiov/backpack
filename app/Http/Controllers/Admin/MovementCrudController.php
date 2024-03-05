<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MovementRequest;
use App\Models\Account;
use App\Models\Category;
use App\Models\Movement;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MovementCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MovementCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\Movement::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/movement');
        CRUD::setEntityNameStrings('movement', 'movements');
    }

    protected function setupListOperation(): void
    {
        $this->crud->addColumn([
            'label' => 'Date',
            'value' => fn ($entity) => (new \DateTime($entity->date))->format('d/m/y'),
        ]);
        $this->crud->addColumn([
            'label' => 'Amount',
            'value' => fn (Movement $entity) => number_format($entity->amount, 2, ',', '.'),
        ]);
        $this->crud->addColumn([
            'label' => 'Description',
            'name' => 'description',
        ]);
        $this->crud->addColumn([
            'label' => 'Account',
            'value' => fn ($entity) => $entity->account->name,
        ]);
        $this->crud->addColumn([
            'label' => 'Category',
            'value' => fn ($entity) => $entity->category?->name,
        ]);
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(MovementRequest::class);

        CRUD::addFields([
            [
                'label' => 'Account',
                'type' => 'select',
                'name' => 'account_id',
                'entity' => 'account',
                'model' => Account::class, // related model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'options' => fn ($query) => $query->orderBy('name', 'ASC')->get(),
            ],
            [
                'label' => 'Category',
                'type' => 'select',
                'name' => 'category_id',
                'entity' => 'category',
                'model' => Category::class, // related model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'options' => fn ($query) => $query->orderBy('name', 'ASC')->get(),
            ],
            [
                'label' => 'Date',
                'type' => 'date',
                'name' => 'date',
            ],
            [
                'label' => 'Amount',
                'type' => 'number',
                'name' => 'amount',
            ],
            [
                'label' => 'Description',
                'type' => 'text',
                'name' => 'description',
            ],
        ]);
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
