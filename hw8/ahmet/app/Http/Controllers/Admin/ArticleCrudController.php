<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ArticleRequest as StoreRequest;
use App\Http\Requests\ArticleRequest as UpdateRequest;

/**
 * Class ArticleCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class ArticleCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel('App\Models\Article');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/article');
        $this->crud->setEntityNameStrings('article', 'articles');

        $this->crud->addColumn(['name' => 'id', 'type' => 'id', 'label' => 'id']);
        $this->crud->addColumn(['name' => 'user.username', 'type' => 'text', 'label' => 'Author']);
        $this->crud->addColumn(['name' => 'header', 'type' => 'text', 'label' => 'Header']);
        $this->crud->addColumn(['name' => 'article', 'type' => 'text', 'label' => 'Article']);
        $this->crud->addColumn(['name' => 'category.name', 'type' => 'text', 'label' => 'Category']);

        $this->crud->addField([  // Select
            'label' => "Author",
            'type' => 'select',
            'name' => 'author_id', // the db column for the foreign key
            'entity' => 'user', // the method that defines the relationship in your Model
            'attribute' => 'username', // foreign key attribute that is shown to user
            'model' => "App\Models\User" // foreign key model
        ]);

        $this->crud->addField(['name' => 'header', 'type' => 'text', 'label' => 'Header']);
        $this->crud->addField(['name' => 'article', 'type' => 'ckeditor', 'label' => 'Article']);
        $this->crud->addField([  // Select
            'label' => "Category",
            'type' => 'select2',
            'name' => 'category_id', // the db column for the foreign key
            'entity' => 'category', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\Category" // foreign key model
        ]);


        // add asterisk for fields that are required in ArticleRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
