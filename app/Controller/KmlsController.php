<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('AppController', 'Controller');

/**
 * AndroidApps Controller
 *
 * @property AndroidApp $AndroidApp
 * @property PaginatorComponent $Paginator
 * @property AclComponent $Acl
 * @property SessionComponent $Session
 */
class KmlsController extends AppController {

    public $components = array('Paginator', 'Acl', 'Session');

    public function add() {
        if ($this->request->is('post')) {
            $this->Kml->create();
            $this->request->data['Kml']['created_by'] = $this->Session->read('Auth.User.User.id');
            if ($this->Kml->save($this->request->data)) {
                $this->Session->setFlash(__('The kml has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The kml could not be saved. Please, try again.'));
            }
        }
        $kmls = $this->Kml->find('list');
        $this->set(compact('kmls'));
    }

    public function index() {
        $this->Kml->recursive = 0;
        $this->set('Kmls', $this->Paginator->paginate());
    }

    public function edit($id = null) {
        if (!$this->Kml->exists($id)) {
            throw new NotFoundException(__('Invalid Kml'));
        }
        if ($this->request->is(array('post', 'put'))) {
            
            $this->request->data['Kml']['created_by'] = $this->Session->read('Auth.User.User.id');
            if ($this->Kml->save($this->request->data)) {
                $this->Session->setFlash(__('The Kml has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The Kml could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Kml.' . $this->Kml->primaryKey => $id));
            $this->request->data = $this->Kml->find('first', $options);
        }
    }

    public function delete($id = null) {
        $this->Kml->id = $id;
        if (!$this->Kml->exists()) {
            throw new NotFoundException(__('Invalid Kml'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Kml->delete()) {
            $this->Session->setFlash(__('The Kml has been deleted.'));
        } else {
            $this->Session->setFlash(__('The Kml could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
