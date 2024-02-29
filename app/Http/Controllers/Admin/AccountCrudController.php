<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AccountRequest;
use App\Models\Account;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AccountCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AccountCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Account::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/account');
        CRUD::setEntityNameStrings('account', 'accounts');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation(): void
    {
        CRUD::column('id');
        CRUD::column('name');
        CRUD::addColumn([
            'name'  => 'status',
            'label' => 'Status',
            'type'  => 'enum',
            'options' => [
                'closed' => 'Closed',
                'open' => 'Open',
                'highlight' => 'Highlight',
            ]
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(AccountRequest::class);

        CRUD::field('name')
             ->type('text');
        CRUD::field('status')
             ->type('select_from_array')
             ->options(['open' => 'Open', 'highlight' => 'Highlight']);

        Account::creating(function($entry) {
            $entry->user_id = backpack_user()->id;
        });
    }

    protected function setupUpdateOperation(): void
    {
        CRUD::setValidation(AccountRequest::class);

        CRUD::field('name')
            ->type('text');

        CRUD::field('status')
            ->type('select_from_array')
            ->options(['closed' => 'Closed', 'open' => 'Open', 'highlight' => 'Highlight']);

        Account::creating(function($entry) {
            $entry->user_id = backpack_user()->id;
        });
    }
}