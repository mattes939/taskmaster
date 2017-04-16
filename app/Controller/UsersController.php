<?php

App::uses('AppController', 'Controller');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
        $this->set('user', $this->User->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        $this->layout = 'login';
        if ($this->request->is('post')) {
            $this->User->Behaviors->attach('Tools.Passwordable', array('require' => false, 'confirm' => false));
            $this->User->create();
            if ($this->User->save($this->data)) {
                $this->Flash->success(__('Registrace proběhla úspěšně.'));
                return $this->redirect(['action' => 'login']);
            } else {
                $this->Flash->error(__('Chyba při vytváření uživatele.'));
                unset($this->request->data['User']['pwd']);
                //    unset($this->request->data['User']['pwd_repeat']);
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
    public function edit() {
        $id = $this->Auth->user('id');
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if (isset($this->request->data['User']['email'])) {
                unset($this->request->data['User']['email']);
            }
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
        }
        $tasks = $this->User->Task->find('list');
        $this->set(compact('tasks'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->User->delete()) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function login() {
        $this->layout = 'login';
        $this->User->Behaviors->attach('Tools.Passwordable');
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirect());
            }
            $this->Flash->error(__('Nesprávné přihlašovací jméno nebo heslo.'));
        }
        if ($this->Session->read('Auth.User')) {
            $this->Flash->success('Přihlášení proběhlo úspěšně!');
            return $this->redirect(['controller' => 'tasks', 'action' => 'index']);
        }
        //    echo $this->Session->flash('auth');
    }

    public function logout() {
        $this->Auth->logout();
        $this->layout = 'login';
        $this->redirect(array('action' => 'login'));
    }

    public function changePassword() {

        if ($this->request->is(array('post', 'put'))) {
            $this->User->Behaviors->attach('Tools.Passwordable', array('current' => false));
            $this->request->data['User']['id'] = $this->Session->read('Auth.User.id');
            if ($this->User->save($this->data, array('fieldList' => array('id')))) {
                $this->Flash->success('Heslo změněno.');
                return $this->redirect(array('controller' => 'tasks', 'action' => 'index'));
            } else {
                $this->Flash->error('Chyba při změně hesla.');
                unset($this->request->data['User']['pwd']);
                unset($this->request->data['User']['pwd_repeat']);
            }
        }
    }

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add');
    }

}
