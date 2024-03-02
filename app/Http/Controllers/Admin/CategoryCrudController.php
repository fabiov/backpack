<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CategoryCrudController
 *
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;

    public function setup(): void
    {
        CRUD::setModel(\App\Models\Category::class);
        CRUD::setRoute(config('backpack.base.route_prefix').'/category');
        CRUD::setEntityNameStrings('category', 'categories');
    }

    /**
     * @see https://backpackforlaravel.com/docs/crud-operation-list-entries
     */
    protected function setupListOperation(): void
    {
        CRUD::setFromDb(); // set columns from db columns.
    }

    protected function setupCreateOperation(): void
    {
        CRUD::setValidation(CategoryRequest::class);

        CRUD::field('name')
            ->type('text');
        CRUD::field('active')
            ->type('checkbox')
            ->default(true);

        Category::creating(function ($entry) {
            $entry->user_id = backpack_user()->id;
        });
    }

    protected function setupUpdateOperation(): void
    {
        CRUD::setValidation(CategoryRequest::class);

        CRUD::field('name')
            ->type('text');
        CRUD::field('active')
            ->type('checkbox');
    }
}
