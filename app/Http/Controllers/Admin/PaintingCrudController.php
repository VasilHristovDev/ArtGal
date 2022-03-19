<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PaintingRequest;
use App\Models\Painting;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PaintingCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class PaintingCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Painting::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/painting');
        CRUD::setEntityNameStrings('painting', 'paintings');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('name');
        CRUD::column('width');
        CRUD::column('height');
        CRUD::column('material');
        CRUD::column('user_id');
        CRUD::column('exhibition_id');
        CRUD::column('genre_id');
        CRUD::column('created_at');
        CRUD::column('updated_at');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
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

        CRUD::setFromDb(Painting::class);
        $this->crud->addField('user_id');
        $this->crud->addField('genre_id');
        $this->crud->addField('exhibition_id');
//        CRUD::field('name');
//        CRUD::field('width');
//        CRUD::field('height');
//        CRUD::field('material');
//        CRUD::field('genre_id');
//        CRUD::field('user_id');
//        CRUD::field('exhibition_id');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
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
