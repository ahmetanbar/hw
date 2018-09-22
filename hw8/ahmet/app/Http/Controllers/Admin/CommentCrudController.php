<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\CommentRequest as StoreRequest;
use App\Http\Requests\CommentRequest as UpdateRequest;

/**
 * Class CommentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class CommentCrudController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel('App\Models\Comment');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/comment');
        $this->crud->setEntityNameStrings('comment', 'comments');

        $this->crud->addColumn(['name' => 'id', 'type' => 'id', 'label' => 'id']);
        $this->crud->addColumn(['name' => 'article.header', 'type' => 'text', 'label' => 'Article']);
        $this->crud->addColumn(['name' => 'user.username', 'type' => 'text', 'label' => 'Writer']);
        $this->crud->addColumn(['name' => 'comment', 'type' => 'text', 'label' => 'Comment']);

        $this->crud->addField([  // Select
            'label' => "Writer",
            'type' => 'select',
            'name' => 'user_id', // the db column for the foreign key
            'entity' => 'user', // the method that defines the relationship in your Model
            'attribute' => 'username', // foreign key attribute that is shown to user
            'model' => "App\Models\User" // foreign key model
        ]);

        $this->crud->addField(['name' => 'comment', 'type' => 'textarea', 'label' => 'Comment']);

        $this->crud->addField([  // Select
            'label' => "Header",
            'type' => 'select2',
            'name' => 'article_id', // the db column for the foreign key
            'entity' => 'article', // the method that defines the relationship in your Model
            'attribute' => 'header', // foreign key attribute that is shown to user
            'model' => "App\Models\Article" // foreign key model
        ]);


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
