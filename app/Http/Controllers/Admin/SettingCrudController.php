<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SettingRequest;
use App\Models\Movement;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class SettingCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SettingCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Setting::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/setting');
        CRUD::setEntityNameStrings('setting', 'settings');
    }

    protected function setupListOperation(): void
    {
        CRUD::setFromDb();
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(SettingRequest::class);

        CRUD::addFields([
            [
                'attributes' => ['min' => 1, 'max' => 28],
                'label' => 'Payday',
                'type' => 'number',
                'name' => 'payday',
            ],
            [
                'attributes' => ['min' => 1, 'max' => 24],
                'label' => 'Months',
                'type' => 'number',
                'name' => 'months',
            ],
            [
                'label' => 'Provisioning',
                'type' => 'checkbox',
                'name' => 'provisioning',
            ],
        ]);
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
