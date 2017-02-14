<?php

App::uses('AppController', 'Controller');

/**
 * Tasks Controller
 *
 * @property Task $Task
 * @property PaginatorComponent $Paginator
 */
class TasksController extends AppController {

    public $helpers = ['Tools.Tree'];

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
//        $tasks = $this->Task->find('threaded', [
//            'contain' => [
//                'User'
//            ],
//            'conditions' => [
//                'User.id' => $this->Auth->user('id')
//            ]
//        ]);
        $tasks = $this->Task->getTasksByUserId($this->Auth->user('id'));
        if ($tasks) {
            $this->set(compact('tasks'));
        }

//        $this->set('tasks', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Task->exists($id)) {
            throw new NotFoundException(__('Invalid task'));
        }

        $task = $this->Task->find('first', [
            'conditions' => [
                'Task.id' => $id,
            ],
            'contain' => [
//                'ParentTask',
//                'ChildTask',
                'User',
                'Author',
                'Value' => [
                    'Property'
                ]
            ],
            'order' => [
                'lft' => 'ASC'
            ]
        ]);
//        debug($task);
        $path = $this->Task->getPath($id, ['id', 'lft', 'rght', 'parent_id', 'name']);

        $children = $this->Task->children($id, false, ['id']);

        $tree = $this->Task->find('threaded', array('order' => array('Task.lft' => 'ASC'),
            'conditions' => [
                'Task.lft >=' => $path[0]['Task']['lft'],
                'Task.rght <=' => $path[0]['Task']['rght'],
            ],
            'fields' => array('name', 'lft', 'rght', 'parent_id', 'id')
        ));
        $root = $path[0]['Task']['id'];
        $this->set(compact('task', 'tree', 'root'));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add($parentId = NULL) {
        if ($this->request->is('post')) {
            $task = $this->request->data;
            $task['Task']['author_id'] = $this->Auth->user('id');
            $task['User']['User'][] = $this->Auth->user('id');
            $this->Task->create();
            if (!empty($parentId)) {
                $saved = $this->Task->saveChild($task, $parentId);
            } else {
                $saved = $this->Task->save($task);
            }
//             debug($task);die;

            if ($saved) {
                $this->Flash->success(__('The task has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The task could not be saved. Please, try again.'));
            }
        }
        $parentTasks = $this->Task->ParentTask->find('list');
        $users = $this->Task->User->find('list', [
            'conditions' => [
                'NOT' => ['id' => $this->Auth->user('id')]
            ]
        ]);

        $this->set(compact('parentTasks', 'users', 'users'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Task->exists($id)) {
            throw new NotFoundException(__('Invalid task'));
        }
        if ($this->request->is(array('post', 'put'))) {        
            if ($this->Task->save($this->request->data)) {
                $this->Flash->success(__('The task has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The task could not be saved. Please, try again.'));
            }
        } else {
            $options = array(
                'conditions' => array(
                    'Task.' . $this->Task->primaryKey => $id
                ),
                'contain' => [
                    'User',
                    'Author',
                    'Value' => [
                        'Property'
                    ]
                ]
            );
            $this->request->data = $this->Task->find('first', $options);
        }
        $parentTasks = $this->Task->ParentTask->find('list');

        $users = $this->Task->User->find('list'
//                , ['limit' => 1]
                );
        $this->set(compact('parentTasks', 'users'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Task->id = $id;
        if (!$this->Task->exists()) {
            throw new NotFoundException(__('Invalid task'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Task->delete()) {
            $this->Flash->success(__('The task has been deleted.'));
        } else {
            $this->Flash->error(__('The task could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function inviteUser($id = NULL){
        if (!$this->Task->exists($id)) {
            throw new NotFoundException(__('Invalid task'));
        }
        if ($this->request->is(array('post', 'put'))) {        
            if ($this->Task->save($this->request->data)) {
                $this->Flash->success(__('The task has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The task could not be saved. Please, try again.'));
            }
        } else {
            $options = array(
                'conditions' => array(
                    'Task.' . $this->Task->primaryKey => $id
                ),
                'contain' => [
                    'User',                    
                ]
            );
            $this->request->data = $this->Task->find('first', $options);
        }
        
        //seznam všech uživatelů, kteří jsou pozváni k aspoň jednomu mému úkolu
        $users = $this->Task->User->getContacts($this->Auth->user('id'));
        $this->set(compact('users'));
        
        
    }
}
