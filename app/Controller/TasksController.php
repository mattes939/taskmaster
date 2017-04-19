<?php
App::uses('AppController', 'Controller');

/**
 * Tasks Controller
 *
 * @property Task $Task
 * @property PaginatorComponent $Paginator
 */
class TasksController extends AppController {

    public $helpers = ['Tools.Tree', 'Time'];

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

        $tasks = $this->Task->getTasksByUserId($this->Auth->user('id'));
        $this->set(compact('tasks'));
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
        if (!in_array($id, $this->Task->getTaskIdsByUserId($this->Auth->user('id')))) {
            throw new ForbiddenException(__('Nemáte oprávnění k tomuto úkolu'));
        }

        if ($this->request->is(array('post', 'put'))) {
//            debug($this->request->data);
            if (!empty($this->request->data['Comment'])) {
                $this->request->data['Comment']['task_id'] = $id;
                $this->request->data['Comment']['user_id'] = $this->Auth->user('id');
                if ($this->Task->Comment->save($this->request->data)) {
                    $this->Flash->success(__('Komentář byl přidán.'));
                    return $this->redirect(array('action' => 'view', $id));
                } else {
                    $this->Flash->error(__('Chyba při ukládání komentáře.'));
                }
            }
        }

        $task = $this->Task->find('first', [
            'conditions' => [
                'Task.id' => $id,
            ],
            'fields' => ['id', 'lft', 'rght', 'name', 'author_id', 'parent_id', 'description'],
            'contain' => [
                'User' => [
                    'fields' => ['id', 'username', 'first_name', 'last_name', 'telephone']
                ],
                'Author' => [
                    'fields' => ['id', 'username', 'first_name', 'last_name']
                ],
                'Value' => [
                    'fields' => ['value', 'property_id', 'id'],
                    'Property' => [
                        'fields' => ['name', 'type_id', 'id']
                    ],
                    'Processing' => [
                        'fields' => ['id', 'name']
                    ]
                ],
                'ParentTask' => [
                    'fields' => ['id', 'name'],
                    'User' => [
                        'fields' => ['id']
                    ]
                ],
                'Comment' => [
                    'order' => ['modified' => 'asc'],
                    'User' => [
                        'fields' => ['id', 'username', 'first_name', 'last_name']
                    ],
                ]
            ],
            'order' => [
                'lft' => 'ASC'
            ]
        ]);

        $path = $this->Task->getPath($id, ['id', 'lft', 'rght', 'parent_id', 'name']);

        $root = $path[0]['Task'];

        $tree = $this->Task->getTasksByUserId($this->Auth->user('id'), $root);

        $canDetach = count($tree[0]['User']) > 1 && count($task['User']) > 1;

        $this->set(compact('task', 'tree', 'root', 'canDetach'));
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

            $this->Task->create();
            if (!empty($parentId)) {
                $saved = $this->Task->saveChild($task, $parentId);
            } else {
                $task['User']['User'][] = $this->Auth->user('id');
                $saved = $this->Task->saveAll($task);
            }

            if ($saved) {
                $this->Flash->success(__('Úkol byl vytvořen.'));
                return $this->redirect(['action' => 'view', $this->Task->id]);
            } else {
                $this->Flash->error(__('The task could not be saved. Please, try again.'));
            }
        }

        $users = [];
        $parentTask = [];
        if (!empty($parentId)) {
            $users = $this->Task->User->getUsersByTaskId($parentId);
            unset($users[$this->Auth->user('id')]);

            $parentTask = $this->Task->find('first', [
                'conditions' => ['id' => $parentId],
                'fields' => ['name', 'id'],
            ]);
        }

        $this->set(compact('users', 'users', 'parentTask'));
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
        $options = array(
            'conditions' => array(
                'Task.' . $this->Task->primaryKey => $id
            ),
            'contain' => [
                'User' => [
                    'fields' => 'id'
                ],
                'Value' => [
                    'fields' => [
                        'id', 'task_id', 'property_id', 'value'
                    ],
                    'Property' => [
                        'id', 'name', 'type_id'
                    ]
                ]
            ]
        );
        $task = $this->Task->find('first', $options);
        if (!$this->_isAuthorized(Hash::extract($task['User'], '{n}.id'))) {
            throw new ForbiddenException(__('Nemáte oprávnění k úpravě tohoto úkolu'));
        }

        if ($this->request->is(array('post', 'put'))) {
//            debug($this->request->data);die;
            if ($this->Task->saveAll($this->request->data)) {
                $this->Flash->success(__('Změny byly uloženy.'));
                return $this->redirect(array('action' => 'view', $id));
            } else {
                $this->Flash->error(__('The task could not be saved. Please, try again.'));
            }
        } else {

            $this->request->data = $task;
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
        $this->Task->id = $id;

        $task = $this->Task->find('first', [
            'conditions' => [
                'Task.id' => $id,
            ],
            'fields' => ['id', 'author_id'],
            'contain' => [
                'User' => [
                    'fields' => ['id']
                ],
            ],
        ]);

        if (!$this->Task->exists() || !($this->Auth->user('id') == $task['Task']['author_id'] || count($task['User'] <= 1))) {
            throw new NotFoundException(__('Invalid task'));
        }

        $this->request->allowMethod('post', 'delete');
        if ($this->Task->delete($id, true)) {
            $this->Flash->success(__('Úkol a všechny jeho podúkoly byly smazány.'));
        } else {
            $this->Flash->error(__('The task could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function share($id = NULL) {
        if (!$this->Task->exists($id)) {
            throw new NotFoundException(__('Invalid task'));
        }
        $options = array(
            'conditions' => array(
                'Task.' . $this->Task->primaryKey => $id
            ),
            'contain' => [
                'User' => ['fields' => ['id']]
            ]
        );
        $task = $this->Task->find('first', $options);
        if (!$this->_isAuthorized(Hash::extract($task['User'], '{n}.id'))) {
            throw new ForbiddenException(__('Nemáte oprávnění k úpravě tohoto úkolu'));
        }

        if ($this->request->is(array('post', 'put'))) {
            if ($this->Task->share($id, $this->request->data['Task']['emails'], $this->Auth->user('id'))) {
                $this->Flash->success(__('Úkol sdílen.'));
                return $this->redirect(array('action' => 'view', $id));
            } else {
                $this->Flash->error(__('The task could not be saved. Please, try again.'));
            }
        } else {

            $this->request->data = $task;
        }

        //seznam všech uživatelů, kteří jsou pozváni k aspoň jednomu mému úkolu
//        $users = $this->Task->User->getContacts($this->Auth->user('id'));
//        $this->set(compact('users'));
    }

    public function detachUser($id = null) {
        $this->Task->id = $id;
        if (!$this->Task->exists()) {
            throw new NotFoundException(__('Invalid task'));
        }
        $options = array(
            'conditions' => array(
                'Task.' . $this->Task->primaryKey => $id
            ),
            'filds' => ['id'],
            'contain' => [
                'User' => ['fields' => ['id']]
            ]
        );
        $task = $this->Task->find('first', $options);
        if (!$this->_isAuthorized(Hash::extract($task['User'], '{n}.id'))) {
            throw new ForbiddenException(__('Nemáte oprávnění k úpravě tohoto úkolu'));
        }
        $this->request->allowMethod('post', 'delete');

        if ($this->Task->detachUser($id, $this->Auth->user('id'))) {
            $this->Flash->success(__('Asociace byla zrušena.'));
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__('The task could not be detached from. Please, try again.'));
        }
    }

    public function changeParent($id = null) {
        if (!$this->Task->exists($id)) {
            throw new NotFoundException(__('Invalid task'));
        }
        $options = array(
            'conditions' => array(
                'Task.' . $this->Task->primaryKey => $id
            ),
            'contain' => [
                'User' => [
                    'fields' => 'id'
                ],
            ]
        );
        $task = $this->Task->find('first', $options);
        if (!$this->_isAuthorized(Hash::extract($task['User'], '{n}.id'))) {
            throw new ForbiddenException(__('Nemáte oprávnění k úpravě tohoto úkolu'));
        }

        if ($this->request->is(array('post', 'put'))) {
//            debug($this->request->data);die;
            if ($this->Task->saveAll($this->request->data)) {
                $this->Task->synchronizeAttributes($id, $this->request->data['Task']['parent_id']);
                $this->Flash->success(__('Změny byly uloženy.'));
                return $this->redirect(array('action' => 'view', $id));
            } else {
                $this->Flash->error(__('The task could not be saved. Please, try again.'));
            }
        } else {

            $this->request->data = $task;
        }
        $myTaskIds = $this->Task->getTaskIdsByUserId($this->Auth->user('id'));
        unset($myTaskIds[$id]);
//        debug($myTaskIds);
        
        $path = $this->Task->getPath($id, ['id', 'lft', 'rght', 'parent_id', 'name']);

        $root = $path[0]['Task'];
        
        
        $parents = $this->Task->generateTreeList([
            'id' => $myTaskIds,
//            'NOT' => [
                'lft >=' => $root['lft'],
                'rght <=' => $root['rght']
//            ]
                ], null, null, '-> ');
        $this->set(compact('parents'));
    }

}
