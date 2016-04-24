<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * Question Model
 *
 * @property QsnSet $QsnSet
 * @property QsnType $QsnType
 * @property ValidityRule $ValidityRule
 * @property SelectMisc $SelectMisc
 */
class Kml extends AppModel {

    public $displayField = "name";
    var $actsAs = array(
        'FileModel' => array(
            'file_field' => array('kml'),
            'file_db_file' => array('file_location'),
            'custom_dir' => array('kml'),
            'use_model_name' => true
        )
    );
    //    public $belongsTo = array(
//        'QuestionSet' => array(
//            'className' => 'QuestionSet',
//            'foreignKey' => 'parent_id',
//            'conditions' => '',
//            'fields' => '',
//            'order' => ''
//        )
//    );
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'created_by',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'ParentKml' => array(
            'className' => 'Kml',
            'foreignKey' => 'parent_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
        
    );

}
