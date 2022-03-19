<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PaintingRequest;
use App\Models\Image;
use App\Models\Painting;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanel;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Storage;

/**
 * Class PaintingCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class PaintingCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation {
        destroy as traitDestroy;
    }
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


        $this->crud->addField(
            [
                'name' => 'gallery',
                'label' => 'Images',
                'type' => 'upload_multiple_modified',
                'upload' => true,
                'attributes' => [
                    'accept' => 'image/*',
                ],
            ]
        )->afterField('featured_image');
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
    public function store()
    {
        $this->crud->setValidation(PaintingRequest::class);
        $response = $this->traitStore();
        $this->savePaintingWithGallery();
        return $response;
    }

    public function update()
    {
        $this->crud->setValidation(UpdatePaintingRequest::class);
        $response = $this->traitUpdate();
        $this->savePaintingWithGallery();
        return $response;
    }

    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');
        $this->deletePainting($id);
        return $this->crud->delete($id);
    }
    private function saveImage($file, $entryID)
    {
        $image = new Image();
        $image->painting_id = $entryID;
        $image->storeMedia($file);
        $image->save();
    }

    private function deleteImage($file)
    {
        Storage::disk('public')->delete(Image::LARGE_PATH.basename($file));
        Storage::disk('public')->delete(Image::ORIGINAL_PATH.basename($file));
        Storage::disk('public')->delete(Image::MEDIUM_PATH.basename($file));
        $image = Image::where('url', basename($file));

        $image->delete();
    }

    private function savePaintingWithGallery()
    {
        $images = $this->crud->getRequest()->files->get('gallery');
        $clearedImages = $this->crud->getRequest()->get('clear_gallery');
        $entryID = $this->data['entry']->id;

        if ($clearedImages && count($clearedImages) > 0) {
            foreach ($clearedImages as $clearedImage) {
                $this->deleteImage($clearedImage);
            }
        }
        $this->crud->setOperationSetting('saveAllInputsExcept', ['gallery']);

        if ($images && count($images) > 0) {
            foreach ($images as $image) {
                $this->saveImage($image, $entryID);
            }
        }

    }
}
