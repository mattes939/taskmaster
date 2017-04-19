<?php

App::uses('AppController', 'Controller');

/**
 * Comments Controller
 *
 * @property Comment $Comment
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class CommentsController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session', 'Flash');

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->Comment->create();
            if ($this->Comment->save($this->request->data)) {
                $this->Flash->success(__('The comment has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('The comment could not be saved. Please, try again.'));
            }
        }
        $tasks = $this->Comment->Task->find('list');
        $users = $this->Comment->User->find('list');
        $this->set(compact('tasks', 'users'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Comment->exists($id)) {
            throw new NotFoundException(__('Invalid comment'));
        }
        $options = array('conditions' => array('Comment.' . $this->Comment->primaryKey => $id));
        $comment = $this->Comment->find('first', $options);
        if($comment['Comment']['user_id'] != $this->Auth->user('id')){
            throw new ForbiddenException('Nemáte oprávnění k úpravě tohoto komentáře!');
        }
        
        $task = $this->Comment->Task->find('first', [
            'conditions' => ['id' => $comment['Comment']['task_id']]
        ]);
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Comment->save($this->request->data)) {
                $this->Flash->success(__('Úprava komentáře uložena.'));
                return $this->redirect(['controller' => 'tasks', 'action' => 'view', $task['Task']['id']]);
            } else {
                $this->Flash->error(__('The comment could not be saved. Please, try again.'));
            }
        } else {

            $this->request->data = $comment;
        }

        $users = $this->Comment->User->find('list');
        $this->set(compact('task', 'users'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Comment->id = $id;
        if (!$this->Comment->exists()) {
            throw new NotFoundException(__('Invalid comment'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Comment->delete()) {
            $this->Flash->success(__('The comment has been deleted.'));
        } else {
            $this->Flash->error(__('The comment could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
