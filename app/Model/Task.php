<?php

App::uses('AppModel', 'Model');
App::uses('CakeEmail', 'Network/Email');

/**
 * Task Model
 *
 * @property Task $ParentTask
 * @property Author $Author
 * @property Task $ChildTask
 * @property Value $Value
 * @property User $User
 */
class Task extends AppModel {

    public $actsAs = array('Tree');

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';


    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'ParentTask' => array(
            'className' => 'Task',
            'foreignKey' => 'parent_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Author' => array(
            'className' => 'User',
            'foreignKey' => 'author_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'ChildTask' => array(
            'className' => 'Task',
            'foreignKey' => 'parent_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Value' => array(
            'className' => 'Value',
            'foreignKey' => 'task_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
    );

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'User' => array(
            'className' => 'User',
            'joinTable' => 'tasks_users',
            'foreignKey' => 'task_id',
            'associationForeignKey' => 'user_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        )
    );

    /**
     * Returns an array of tasks based on a user id
     * @param string $userId - the id of an user
     * @return array of tasks
     */
    public function getTasksByUserId($userId, $root = null) {

        $conditions = array(
            'TasksUser.user_id' => $userId,
            'TasksUser.task_id = Task.id'
        );
        if (!empty($root)) {
            $conditions['Task.lft >='] = $root['lft'];
            $conditions['Task.rght <='] = $root['rght'];
        }

        $tasks = $this->find('all', array(
            'joins' => array(
                array('table' => 'tasks_users',
                    'alias' => 'TasksUser',
                    'type' => 'INNER',
                    'conditions' => $conditions
                )
            ),
            'group' => 'Task.id',
            'order' => ['Task.lft' => 'ASC'],
            'contain' => [
                'User' => [
                    'fields' => ['User.id']
                ]
            ]
        ));
        return $tasks;
    }

    public function getTaskIdsByUserId($userId = null) {

        $tasks = $this->find('list', array(
            'joins' => array(
                array('table' => 'tasks_users',
                    'alias' => 'TasksUser',
                    'type' => 'INNER',
                    'conditions' => array(
                        'TasksUser.user_id' => $userId,
                        'TasksUser.task_id = Task.id'
                    )
                )
            ),
            'group' => 'Task.id',
            'order' => ['Task.id' => 'ASC'],
            'fields' => ['Task.id']
        ));
        return $tasks;
    }

//    public function 

    public function saveChild($task, $parentId) {
        $users = $this->User->getUserIdsByTaskId($parentId);
//        debug($users);die;
        $task['User']['User'] = $users;
        $task['Task']['parent_id'] = $parentId;

        $properties = $this->Value->find('list', [
            'conditions' => [
                'Value.task_id' => $parentId
            ],
            'fields' => ['id', 'property_id']
        ]);
        foreach ($properties as $i => $property) {
            $task['Value'][]['property_id'] = $property;
        }
        return $this->saveAll($task);
    }

    public function share($id, $emailsString, $userId) {
        $return = false;
        if (!empty($emailsString)) {
            $emails = $this->_processEmails($id, $emailsString, $userId);
            if (!empty($emails)) {
                $return = $this->_associateUsers($id, $emails);
            }
        }

        return $return;
    }

    private function _processEmails($id, $emailsString, $userId) {
        $sanitized = preg_replace('/\s+/', '', $emailsString);
        $emails = explode(',', $sanitized);

        foreach ($emails as $i => $email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                unset($emails[$i]);
            }
        }
        if (!empty($emails)) {
            foreach ($emails as $email) {
                $nonExist = $this->User->find('list', ['conditions' => ['username' => $email]]);

                if (empty($nonExist)) {
                    $this->User->create();
                    $password = $this->generateRandomString();
                    $this->User->Behaviors->attach('Tools.Passwordable', array('require' => false, 'confirm' => false));
                    $this->User->save([
                        'User' => [
                            'username' => $email,
                            'pwd' => $password,
                            'active' => 1
                        ],
                    ]);
                    $this->sendRegistration($email, $id, $userId, $password);
                } else {
                    $this->sendRegistration($email, $id, $userId);
                }
            }
        }
        return $emails;
    }

    private function _associateUsers($id, $emails = NULL) {

        $return = false;
        $data = [];
        $data['Task']['id'] = $id;
        $saveUsers = $this->User->find('list', ['conditions' => ['username' => $emails], 'fields' => ['id']]);
        $existingUsers = $this->find('first', [
            'conditions' => ['id' => $id],
            'contain' => ['User.id'],
            'fields' => ['id']
        ]);

        foreach ($existingUsers['User'] as $user) {
            $saveUsers[] = $user['id'];
        }
        if (!empty($saveUsers)) {
            $children = $this->children($id, false, ['id']);
            $data['User']['User'] = array_values($saveUsers);
            foreach ($children as $i => $child) {
                $children[$i]['User'] = $data['User'];
            }
            $children[] = $data;
            $return = $this->saveAll($children, ['deep' => true]);
        }

        return $return;
    }

    public function sendRegistration($recipient, $id, $userId, $password = null) {
        $task = $this->findById($id, ['name']);
        $user = $this->User->findById($userId, ['username']);

//        debug($task);
//        die;
        $from = $user['User']['username'];
        $viewVars = array(
            'task' => $task['Task']['name'],
        );
        $template = 'shared_task';
        $subject = '[Taskmaster] Nový úkol';

        if (!empty($password)) {
            $viewVars['password'] = $password;
            $template .= '_new_user';
            $subject = '[Taskmaster] Vítejte v aplikaci';
        }

        $email = new CakeEmail();

        $email->config(array(
            'from' => $from,
            'to' => $recipient,
            'subject' => $subject,
            'emailFormat' => 'html',
            'template' => $template,
            'viewVars' => $viewVars,
//                'bcc' => 'matejek@tvorime-weby.cz'
        ));
        $email->send();
    }

    public function detachUser($id, $userId) {
        $path = $this->getPath($id, ['id']);
        $children = $this->children($id, false, ['id']);

        $pathIds = Hash::extract($path, '{n}.Task.id');
        $childrenIds = Hash::extract($children, '{n}.Task.id');

        return $this->TasksUser->deleteAll(['TasksUser.task_id' => array_merge($pathIds, $childrenIds), 'TasksUser.user_id' => $userId], false);
    }

}
