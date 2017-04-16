<?php

App::uses('AppModel', 'Model');

/**
 * Value Model
 *
 * @property Task $Task
 * @property Property $Property
 */
class Value extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'value';
    public $virtualFields = [
        'sum' => 'COUNT(*)'
    ];


    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Task' => array(
            'className' => 'Task',
            'foreignKey' => 'task_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Processing' => array(
            'className' => 'Processing',
            'foreignKey' => 'processing_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Property' => array(
            'className' => 'Property',
            'foreignKey' => 'property_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public function saveChildValues($taskId = NULL, $propertyId = NULL) {
        $children = $this->Task->children($taskId, false, ['id']);

        if (!empty($children)) {
            $children = Hash::extract($children, '{n}.Task.id');
            $attributes = [];
            foreach ($children as $i => $child) {
                $attributes[$i]['Value']['task_id'] = $child;
                $attributes[$i]['Value']['property_id'] = $propertyId;
            }
            $this->saveAll($attributes);
        }
    }

    public function updateParentTaskValues($parentTaskId = null, $propertyId = null, $propertyTypeId = null) {
        $parentProcessingId = null;
        while (!($parentTaskId == NULL || $parentProcessingId == 1)) {

            $parentValue = $this->find('first', [
                'conditions' => ['task_id' => $parentTaskId, 'property_id' => $propertyId]
            ]);
            if ($parentValue['Value']['processing_id'] != 1) {
                $parentTask = $this->Task->find('first', [
                    'conditions' => ['id' => $parentTaskId]
                ]);
                $siblingTaskIds = $this->Task->find('list', [
                    'conditions' => ['parent_id' => $parentTaskId],
                    'fields' => 'id',
//                    'contain' => [
//                        'Value' => [
//                            'conditions' => [
//                                'property_id' => $propertyId
//                            ],
//                            'fields' => ['value']
//                        ]
//                    ]
                ]);
                debug($siblingTaskIds);
                switch ($parentValue['Value']['processing_id']) {
                    case 2: $result = $this->_minimum($siblingTaskIds, $propertyTypeId);
                        break;
                    case 3: $result = $this->_maximum($siblingTaskIds, $propertyTypeId);
                        break;
                    case 4: $result = $this->_sum($siblingTaskIds, $propertyTypeId);
                        break;
                    case 5: $result = $this->_average($siblingTaskIds, $propertyTypeId);
                        break;
                }
                debug($result);
                die;
            }
            $parentProcessingId = $parentValue['Value']['processing_id'];
        }
    }

    private function _minimum($siblingTaskIds, $propertyTypeId) {
        $return = null;

        switch ($propertyTypeId) {
            case 2: //číslo
            case 4: //datum
                $result = $this->find('first', [
                    'conditions' => ['task_id' => $siblingTaskIds],
                    'order' => ['value' => 'ASC']
                ]);
                $return = Hash::extract($result, '{n}.value');
                break;
            case 3: //boolean
                $results = $this->find('all', [
                    'conditions' => ['task_id' => $siblingTaskIds],
                    'order' => ['Value.sum' => 'ASC'],
                    'fields' => ['Value.sum', 'Value.value'],
                    'group' => 'Value.value'
                ]);
                debug($results);
                if (!empty($results)) {
                    $return = $this->_undecided($results[0]['Value']['value']);
                    
                    if (count($results) > 1) {
                        $i = 1;
                        while ($results[$i]['Value']['sum'] == $results[0]['Value']['sum']) {
                            $return .= ', ' . $this->_undecided($results[$i]['Value']['value']);
                            $i++;
                        }
                    }
                }
                
                debug($return);
                break;
            case 5 : //enum
                break;
        }


        return $return;
    }

    private function _maximum($siblingTaskIds, $propertyTypeId) {
        $return = NULL;

        switch ($propertyTypeId) {
            case 2: //číslo
            case 4: //datum
                $result = $this->find('first', [
                    'conditions' => ['task_id' => $siblingTaskIds],
                    'order' => ['value' => 'ASC']
                ]);
                $return = Hash::extract($result, '{n}.value');
                break;
            case 3: //boolean
                 $results = $this->find('all', [
                    'conditions' => ['task_id' => $siblingTaskIds],
                    'order' => ['Value.sum' => 'DESC'],
                    'fields' => ['Value.sum', 'Value.value'],
                    'group' => 'Value.value'
                ]);
                debug($results);
                if (!empty($results)) {
                    $return = $this->_undecided($results[0]['Value']['value']);
                    
                    if (count($results) > 1) {
                        $i = 1;
                        while ($results[$i]['Value']['sum'] == $results[0]['Value']['sum']) {
                            $return .= ', ' . $this->_undecided($results[$i]['Value']['value']);
                            $i++;
                        }
                    }
                }
                break;
            case 5 : //enum
                break;
        }

        return $return;
    }

    private function _sum($siblingTaskIds, $propertyTypeId) {
        $return = null;
        $results = $this->find('list', [
            'conditions' => ['task_id' => $siblingTaskIds],
            'order' => ['value' => 'ASC'],
            'fields' => ['id', 'value']
        ]);
        switch ($propertyTypeId) {
            case 1: //string
                $return = implode(';', $results);
                break;
            case 2: //číslo
                $return = array_sum($results);
                break;
            case 3:
                foreach ($results as $result) {
                    if ($result == 0) {
                        $return = false;
                        break;
                    }
                    if ($result == null) {
                        break;
                    }
                }
                break;
        }
        return $return;
    }

    private function _average($siblingTaskIds, $propertyTypeId) {
        $return = null;

        if ($propertyTypeId == 2) {
            $results = $this->find('list', [
                'conditions' => ['task_id' => $siblingTaskIds, 'NOT' => ['value' => null]],
                'order' => ['value' => 'ASC'],
                'fields' => ['id', 'value']
            ]);
            if (!empty($results)) {
                $return = array_sum($results);
            }
        }

        return $return;
    }

    private function _undecided($value) {
        if ($value === null) {
            $value = '[nevybráno]';
        }

        return $value;
    }

}
