<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ImageUploadRequest;
use App\Base\BaseCrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ImageUploadCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ImageUploadCrudController extends BaseCrudController
{
    public function setup()
    {
        $this->crud->setModel('App\Models\ImageUpload');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/uploadimage');
        $this->crud->setEntityNameStrings('Upload Image', 'Upload Image');
    }

    protected function setupListOperation()
    {
        $col = [
           $this->addRowNumber(),
           $this->addCodeColumn(),
           [  // Select
            'label' => trans('Image Category'),
            'type' => 'select',
            'name' => 'image_category_id', // the db column for the foreign key
            'entity' => 'imagecategory', // the method that defines the relationship in your Model
            'attribute' => 'name_lc', // foreign key attribute that is shown to user
            'model' => "App\Models\ImageCategory",
           ],
        ];
            $this->crud->addColumns($col);

            $this->addFilters();
            $this->crud->orderBy('id');
    }

    private function addFilters()
    {
        $this->crud->addFilter(
            [ // Name(en) filter
                'label' => trans('Image Category'),
                'type' => 'select2',
                'name' => 'image_category_id', // the db column for the foreign key
            ],
            function () {
                return (new \App\Models\ImageCategory())->getFilterComboOptions();
            },
            function ($value) { // if the filter is active
                $this->crud->addClause('where', 'image_category_id', $value);
            }
        );
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(ImageUploadRequest::class);

        $arr=[
            $this->addCodeField(),
            [ // CustomHTML
                'name' => 'fieldset_open',
                'type' => 'custom_html',
                'value' => '<fieldset>',
            ],
            [  // Select
                'label' => trans('Image Category'),
                'type' => 'select2',
                'name' => 'image_category_id', // the db column for the foreign key
                'entity' => 'imagecategory', // the method that defines the relationship in your Model
                'attribute' => 'name_lc', // foreign key attribute that is shown to user
                'model' => "App\Models\ImageCategory",
                // optional
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
                // optional
                'options'   => (function ($query) {
                    return (new \App\Models\ImageCategory())->getFieldComboOptions($query);
                }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
            ],
            [
                'name' => 'image_path',
                'type' => 'upload_multiple',
                'label' => trans('Upload image'),
                'upload' => true,
                'disk' => 'uploads',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-8',
                ],
            ],

        ];
        $this->crud->addFields($arr);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
