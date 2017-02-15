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
                $this->Flash->error(__('Atribut vložen.'));
                return $this->redirect(array('controller' => 'tasks', 'action' => 'view', $taskId));
            } else {
                $this->Flash->error(__('The value could not be saved. Please, try again.'));
            }
        } else{
            $task = $this->Value->Task->findById($taskId);
            $this->set(compact('task'));
        }
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
