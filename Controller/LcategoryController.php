<?php

class LcategoryController extends LwikiAppController
{
    public function getWiki()
    {
        $this->autoRender = false;
        $this->response->type('json');
        if ($this->request->is('post')) {
            $this->loadModel('Lwiki.Lcategory');
            $id = $this->request->data['id'];
            $category = $this->Lcategory->findById($id);
            $this->response->body(json_encode(array('statut' => true, 'slug' => $category['Lcategory']['name'], 'content' => htmlspecialchars_decode($category['Lcategory']['text']))));
        }
    }

    public function admin_edit($id)
    {
        if ($this->isConnected and $this->User->isAdmin()) {
            $this->layout = 'admin';
            if ($id != false) {
                $this->loadModel('Lwiki.Lcategory');
                $search = $this->Lcategory->findById($id);
                if (!empty($search)) {
                    $category = $search['Lcategory'];
                    $this->set(compact('category'));
                } else {
                    throw new NotFoundException();
                }
            } else {
                $this->redirect('/');
            }
        }

    }

    public function admin_edit_ajax()
    {
        $this->autoRender = false;
        $this->response->type('json');
        if ($this->isConnected and $this->User->isAdmin()) {
            if ($this->request->is('post')) {
                $this->loadModel('Lwiki.Lcategory');

                $id = $this->request->data['id'];
                $name = $this->request->data['name'];
                $text = $this->request->data['text'];

                $this->Lcategory->set($this->request->data);
                if ($this->Lcategory->validates()) {
                    $this->Lcategory->edit($id, $name, $text);
                    $this->response->body(json_encode(array('statut' => true, 'msg' => $this->Lang->get('SHOP__CATEGORY_EDIT_SUCCESS'))));
                } else {
                    $this->response->body(json_encode(array('statut' => false, 'msg' => $this->alertMesasge($this->Lcategory->validationErrors))));
                }
            } else {
                $this->response->body(json_encode(array('statut' => false, 'msg' => $this->Lang->get('ERROR__BAD_REQUEST'))));
            }
        } else {
            throw new ForbiddenException();
        }
    }

    public function index()
    {
        $this->loadModel('Lwiki.Ltypes');
        $this->loadModel('Lwiki.Lcategory');
        $types = $this->Ltypes->find('all');
        $categorys = $this->Lcategory->find('all');
        $this->set(compact('types', 'categorys'));
        $this->set('title_for_layout', 'Wiki');
    }

    public function admin_delete($id)
    {
        if ($this->isConnected and $this->User->isAdmin()) {
            $this->autoRender = null;

            $this->loadModel('Lwiki.Lcategory');

            $this->Lcategory->_delete($id);

            $this->redirect('/admin/lwiki');
        } else {
            $this->redirect('/toto');
        }
    }

    public function admin_edit_display_ajax()
    {
        $this->autoRender = false;
        if ($this->isConnected and $this->User->isAdmin()) {

            if ($this->request->is('post')) {
                $this->loadModel('Lwiki.Lcategory');

                $id = $this->request->data['id'];
                $this->Lcategory->edit_display_ajax($id);
                $display = $this->Lcategory->findById($id);
                return $this->sendJSON(['statut' => true, 'display' => $display['Lcategory']['display'], 'msg' => $this->Lang->get('SHOP__SAVE_SUCCESS')]);
            }
        }
    }

    public function admin_edit_collapse_ajax()
    {
        $this->autoRender = false;
        if ($this->isConnected and $this->User->isAdmin()) {

            if ($this->request->is('post')) {
                $this->loadModel('Lwiki.Lcategory');

                $id = $this->request->data['id'];
                $this->Lcategory->edit_collapse_ajax($id);
                return $this->sendJSON(['statut' => true, 'msg' => $this->Lang->get('SHOP__SAVE_SUCCESS')]);
            }
        }
    }

    public function admin_save_ajax()
    {
        $this->autoRender = false;
        if ($this->isConnected and $this->User->isAdmin()) {

            if ($this->request->is('post')) {
                if (!empty($this->request->data)) {

                    //I explode the contents of the wiki_category_order to retrieve the name of each item.
                    $data = $this->request->data['wiki_category_order'];
                    $data = explode('&', $data);

                    //I explode the contents of the wiki_type_name to retrieve the name of the selected category.
                    $category = $this->request->data['wiki_type_name'];
                    $category = explode('-', $category);

                    //I explode the contents of the wiki_category_name_selected to retrieve the name of the selected category.
                    $itemIdSelected = $this->request->data['wiki_category_name_selected'];
                    $itemIdSelected = explode('-', $itemIdSelected);

                    $i = 1;
                    foreach ($data as $key => $value) {
                        $data2[] = explode('=', $value);
                        $data3 = substr($data2[0][0], 0, -2);
                        $data1[$data3] = $i;
                        unset($data3);
                        unset($data2);
                        $i++;
                    }
                    $data = $data1;


                    //we change the modules
                    $this->loadModel('Lwiki.Ltypes');
                    $this->loadModel('Lwiki.Lcategory');

                    //We retrieve the information of the element passed in variable ex: id, name, etc...
                    $typeName = $this->Ltypes->findByName($category[0]);
                    $categoryName = $this->Lcategory->findByName($itemIdSelected[0]);

                    foreach ($data as $key => $value) {
                        $find = $this->Lcategory->findByName($key);
                        if (!empty($find)) {
                            $id = $find['Lcategory']['id'];

                            $this->Lcategory->editTypeAndOrderFindId(
                                $id,
                                $value,
                                $categoryName['Lcategory']['id'],
                                $typeName['Ltypes']['id']);

                        } else {
                            $error = 1;
                        }
                    }

                    if (empty($error)) {
                        return $this->sendJSON(['statut' => true, 'msg' => $this->Lang->get('SHOP__SAVE_SUCCESS')]);
                    } else {
                        return $this->sendJSON(['statut' => false, 'msg' => $this->Lang->get('ERROR__FILL_ALL_FIELDS')]);
                    }
                } else {
                    return $this->sendJSON(['statut' => false, 'msg' => $this->Lang->get('ERROR__FILL_ALL_FIELDS')]);
                }
            } else {
                return $this->sendJSON(['statut' => false, 'msg' => $this->Lang->get('ERROR__BAD_REQUEST')]);

            }
        } else {
            $this->redirect('/');
        }
    }

}