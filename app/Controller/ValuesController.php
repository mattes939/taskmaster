<?php

App::uses('AppController', 'Controller');

/**
 * Values Controller
 *
 * @property Value $Value
 * @property PaginatorComponent $Paginator
 */
class ValuesController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Value->recursive = 0;
        $this->set('values', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Value->exists($id)) {
            throw new NotFoundException(__('Invalid value'));
        }
        $options = array('conditions' => array('Value.' . $this->Value->primaryKey => $id));
        $this->set('value', $this->Value->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add($taskId = null) {
        if ($this->request->is('post')) {
            $attribute['Property'] = $this->request->data['Property'];
            $attribute['Value'][0] = $this->request->data['Value'];
            $attribute['Value'][0]['task_id'] = $taskId;

            if ($this->Value->Property->saveAttribute($attribute)) {
                return $this->redirect(array('controller' => 'tasks', 'action' => 'view', $taskId));
            } else {
                $this->Flash->error(__('The value could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Value->exists($id)) {
            throw new NotFoundException(__('Invalid value'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Value->save($this->request->data)) {
                $this->Flash->success(__('The value has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The value could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Value.' . $this->Value->primaryKey => $id));
            $this->request->data = $this->Value->find('first', $options);
        }
        $tasks = $this->Value->Task->find('list');
        $properties = $this->Value->Property->find('list');
        $this->set(compact('tasks', 'properties'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Value->id = $id;
        if (!$this->Value->exists()) {
            throw new NotFoundException(__('Invalid value'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Value->delete()) {
            $this->Flash->success(__('The value has been deleted.'));
        } else {
            $this->Flash->error(__('The value could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
