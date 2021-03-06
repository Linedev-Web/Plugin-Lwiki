<?php

class LconfigController extends LwikiAppController
{

    public function admin_index()
    {
        if ($this->isConnected AND $this->Permissions->can('WIKI_ADMIN_MANAGE_WIKI')) {
            $this->layout = 'admin';
            $this->loadModel('Lwiki.Lconfig');
            $this->loadModel('Lwiki.Lcolor');
            $config = $this->Lconfig->get();
            $color = $this->Lcolor->get();
            if (isset($config) && !empty($config)) {
                $config = $config[0]['Lconfig'];
            } else {
                $config = null;
            }
            if (isset($color) && !empty($color)) {
                $color = json_decode($color[0]['Lcolor']['color'], true);
            } else {
                $color = null;
            }
            $this->set(compact('config', 'color'));
        } else {
            $this->redirect('/');
        }
    }

    public function admin_edit_info()
    {
        if ($this->isConnected AND $this->Permissions->can('WIKI_ADMIN_MANAGE_WIKI')) {
            if ($this->request->is('post')) {
                $this->response->type('json');
                $this->autoRender = null;
                $this->loadModel('Lwiki.Lconfig');

                $this->Lconfig->set($this->request->data);
                if ($this->Lconfig->validates()) {

                    $title = $this->request->data('title');
                    $content = $this->request->data('content');
                    $position = $this->request->data('position');
                    $this->Lconfig->edit($title, $content, $position);
                    $this->response->body(json_encode(array('statut' => true, 'msg' => $this->Lang->get('WIKI__SAVE_SUCCESS'))));

                } else {
                    $this->response->body(json_encode(array('statut' => false, 'msg' => $this->alertMesasge($this->Lconfig->validationErrors))));
                }
            } else {
                $this->redirect('/');
            }
        }
    }

    public function admin_edit_color()
    {
        $this->autoRender = null;
        $this->response->type('json');
        if ($this->isConnected AND $this->Permissions->can('WIKI_ADMIN_MANAGE_WIKI')) {
            if ($this->request->is('post')) {
                $this->loadModel('Lwiki.Lconfig');
                $this->loadModel('Lwiki.Lcolor');
                $this->Lcolor->set($this->request->data);
                if ($this->Lcolor->validates()) {

                    $this->Lconfig->editColor(1);
                    $this->Lcolor->edit(1, json_encode($this->request->data));
                    $this->response->body(json_encode(array('statut' => true, 'msg' => $this->Lang->get('WIKI__SUCCESS_COLOR'))));

                } else {
                    $this->response->body(json_encode(array('statut' => false, 'msg' => $this->alertMesasge($this->Lconfig->validationErrors))));
                }
            } else {
                $this->redirect('/');
            }
        }
    }
}