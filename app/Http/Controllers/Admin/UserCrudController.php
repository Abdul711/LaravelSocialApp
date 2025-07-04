<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
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
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
          
    }


    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupShowOperation()
{
    // Prevent auto-loading from DB
    // $this->crud->set('show.setFromDb', false);
      $this->crud->removeButton('show');   // removes "View"
    $this->crud->removeButton('edit');   // removes "Edit"
    $this->crud->removeButton('delete'); // removes "Delete"
    $this->crud->removeAllButtons();
 $this->crud->set('show.setFromDb', true); 
    $this->crud->addColumn([
    'name'   => 'pic', // name of the db column
    'label'  => 'Photo', // table column heading
    'type'   => 'image',
    'prefix' => 'profilepic/', // relative to public/
    'height' => '60px',
    'width'  => '60px',
        ],
);

   
  
}
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // set columns from db columns.

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
        $this->crud->set('show.setFromDb', false);
        $this->crud->addClause('where', 'role', '!=', 'admin');
$this->crud->addColumn([
    'name'  => 'S.No',
    'label' => '#',
    'type'  => 'model_function',
    'function_name' => 'getRowNumber',
    'orderable' => false,
]);
         $this->crud->addColumn([
    'name'   => 'pic', // name of the db column
    'label'  => 'Photo', // table column heading
    'type'   => 'image',
    'prefix' => 'profilepic/', // relative to public/
    'height' => '60px',
    'width'  => '60px',
        ],
);

$this->crud->addColumns([
    [
        'name'  => 'name',
        'label' => 'Name',
        'type'  => 'text',
    ],
    [
        'name'  => 'email',
        'label' => 'Email',
        'type'  => 'email',
    ],
    [
        'name'  => 'created_at',
        'label' => 'Created At',
        'type'  => 'date',
    ],
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
        CRUD::setValidation(UserRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
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
