<?php
App::uses('AppModel', 'Model');
/**
 * Processing Model
 *
 * @property Value $Value
 * @property Type $Type
 */
class Processing extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Value' => array(
			'className' => 'Value',
			'foreignKey' => 'processing_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Type' => array(
			'className' => 'Type',
			'joinTable' => 'processings_types',
			'foreignKey' => 'processing_id',
			'associationForeignKey' => 'type_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

}
