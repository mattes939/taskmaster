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
    public function add($taskId = null, $typeId = null) {
        if ($this->request->is('post')) {

            if ($this->request->data['Property']['type_id'] == 5) {

//                debug($this->request->data);
                $serialize['name'] = $this->request->data['Property']['name'];
                $serialize['options'] = $this->request->data['Property']['options'];
                $this->request->data['Property']['name'] = serialize($serialize);
//                 debug($this->request->data);
//                die;
            }
            unset($this->request->data['Property']['options']);
            $attribute['Property'] = $this->request->data['Property'];
//            $attribute['Property']['type_id'] = $typeId;
//            $attribute['Value'][0] = $this->request->data['Value'];
            $attribute['Value'][0]['task_id'] = $taskId;

            if ($this->Value->Property->saveAttribute($attribute)) {
                $this->Flash->success(__('Atribut vložen.'));
                return $this->redirect(array('controller' => 'tasks', 'action' => 'view', $taskId));
            } else {
                $this->Flash->error(__('The value could not be saved. Please, try again.'));
            }
        } else {
            $task = $this->Value->Task->findById($taskId);
            $types = $this->Value->Property->Type->find('list');
            $this->set(compact('task', 'typeId', 'types'));
        }
    }

    /* edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */

    public function edit($id = null) {
        if (!$this->Value->exists($id)) {
            throw new NotFoundException(__('Invalid value'));
        }

        $value = $this->Value->find('first', [
            'conditions' => ['Value.' . $this->Value->primaryKey => $id],
            'contain' => [
                'Task' => [
                    'fields' => ['name', 'id', 'parent_id']
                ],
                'Property' => [
                    'Type' => [
                        'Processing'
                    ]
                ]
            ]
        ]);

        if ($this->request->is(array('post', 'put'))) {
            
            $this->Value->updateParentTaskValues($value['Task']['parent_id'], $value['Property']['id'], $value['Property']['type_id']);
            //po testování přehodit za save
            if ($this->Value->save($this->request->data)) {
                
                $this->Flash->success(__('The value has been saved.'));
                return $this->redirect(array('controller' => 'tasks', 'action' => 'view', $value['Task']['id']));
            } else {
                $this->Flash->error(__('The value could not be saved. Please, try again.'));
            }
        } else {
            if ($value['Property']['type_id'] == 5) {
                $unserialized = unserialize($value['Property']['name']);
//            debug($unserialized);
                $value['Property']['name'] = $unserialized['name'];
                $options = explode(';', $unserialized['options']);
                $value['Property']['options'] = array_combine($options, $options);
            }
            $this->request->data = $value;
        }
//          debug($value);
        $child = $this->Value->Task->find('first', [
            'conditions' => ['parent_id' => $value['Task']['id']]
        ]);
        if (empty($child)) {
            $processing = [1 => 'zadání'];
        } else {
            $processing = Hash::combine($value['Property']['Type']['Processing'], '{n}.id', '{n}.name');
        }



//                debug($processing);
        $this->set(compact('processing'));
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
