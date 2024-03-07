<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AccountRequest;
use App\Models\Account;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class AccountCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\Account::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/account');
        CRUD::setEntityNameStrings('account', 'accounts');

        $this->crud->operation(['list', 'show', 'update', 'delete'], function() {
            $this->crud->addClause(fn ($query) => $query->where('user_id', backpack_user()->id));
        });
    }

    protected function setupListOperation(): void
    {
        CRUD::column('id');
        CRUD::column('name');
        CRUD::addColumn([
            'name' => 'status',
            'label' => 'Status',
            'type' => 'enum',
            'options' => [
                'closed' => 'Closed',
                'open' => 'Open',
                'highlight' => 'Highlight',
            ],
        ]);
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(AccountRequest::class);

        $this->crud->addField([
            'label' => 'Nome',
            'name' => 'name',
            'type' => 'text',
        ]);
        $this->crud->addField([
            'name' => 'status',
            'type' => 'select_from_array',
            'options' => ['open' => 'Open', 'highlight' => 'Highlight'],
        ]);

        Account::creating(function ($entry) {
            $entry->user_id = backpack_user()->id;
        });
    }

    protected function setupUpdateOperation(): void
    {
        CRUD::setValidation(AccountRequest::class);

        $this->crud->addField([
            'label' => 'Nome',
            'name' => 'name',
            'type' => 'text',
        ]);
        $this->crud->addField([
            'name' => 'status',
            'type' => 'select_from_array',
            'options' => ['closed' => 'Closed', 'open' => 'Open', 'highlight' => 'Highlight'],
        ]);

        Account::creating(function ($entry) {
            $entry->user_id = backpack_user()->id;
        });
    }
}
