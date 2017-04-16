<?php
App::uses('AppController', 'Controller');
/**
 * Processings Controller
 *
 * @property Processing $Processing
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class ProcessingsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Processing->recursive = 0;
		$this->set('processings', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Processing->exists($id)) {
			throw new NotFoundException(__('Invalid processing'));
		}
		$options = array('conditions' => array('Processing.' . $this->Processing->primaryKey => $id), 'recursive' => 1);
		$this->set('processing', $this->Processing->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Processing->create();
			if ($this->Processing->save($this->request->data)) {
				$this->Flash->success(__('The processing has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The processing could not be saved. Please, try again.'));
			}
		}
		$types = $this->Processing->Type->find('list');
		$this->set(compact('types'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Processing->exists($id)) {
			throw new NotFoundException(__('Invalid processing'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Processing->save($this->request->data)) {
				$this->Flash->success(__('The processing has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The processing could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Processing.' . $this->Processing->primaryKey => $id));
			$this->request->data = $this->Processing->find('first', $options);
		}
		$types = $this->Processing->Type->find('list');
		$this->set(compact('types'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Processing->id = $id;
		if (!$this->Processing->exists()) {
			throw new NotFoundException(__('Invalid processing'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Processing->delete()) {
			$this->Flash->success(__('The processing has been deleted.'));
		} else {
			$this->Flash->error(__('The processing could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
