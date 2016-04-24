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
class UserDirectory extends AppModel {

    public $displayField = "name";
    public $useTable = "user_directory";
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
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}
