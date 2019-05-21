<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->autoReder = false;

        $users = $this->paginate($this->Users)->toArray();
        if($this->request->is('get')){
            if(!empty($users)){
                $json = [
                    'error' => 0,
                    'data' => $users
                ]; 
                $body = $this->response->getBody();
                $body->write(json_encode($json));
                return $this->response->withBody($body);
            }else{
                $response = $this->response->withStatus('204');
                return $response;
            }
                       
        }
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function getFindById($id = null)
    {
        $user = $this->Users->findById($id)->first();       
        if ($user) {
            $json = [
                'error' => 0,
                'data'=> $user
            ];
        } else {
            $json = [
                'error' => 1,
                'message' => 'Dato no encontrado'
            ];
        }
                   
        $body = $this->response->getBody();
        $body->write(json_encode($json));
        return $this->response->withBody($body);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->autoRender =false;
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                
                $json = [
                    'error' => 0,
                    'message' => 'Usuario agregado correctamente',
                    'data'=> $user
                ];
            }else{
                $json = [
                    'error' => 1,
                    'message' => $user->getErrors()
                ];
            }
         }else{
            $json = [
                'error' => 1,
                'message' => 'metodo incorrecto'
            ];
         }
         $body = $this->response->getBody();
         $body->write(json_encode($json));
         return $this->response->withBody($body);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->autoRender = false;
        $user = $this->Users->findById($id)->first();

        if($user){
                if ($this->request->is(['patch','put'])) {
                    $user = $this->Users->patchEntity($user, $this->request->getData());
                    if ($this->Users->save($user)) {
                        $json = [
                            'error' => 0,
                            'message' => 'Usuario actualizado  correctamente',
                            'data'=> $user
                        ];
                    }
                    else{
                        $json = [
                            'error' => 1,
                            'message' => $user->getErrors()
                        ];
                    }
                    
                }else{
                    $json = [
                        'error' => 1,
                        'message' => 'metodo incorrecto'
                    ];
                }
         }else{

            $json = [
                'error' => 1,
                'message' => 'Dato no encontrado'
            ];
         }
         
         $body = $this->response->getBody();
         $body->write(json_encode($json));
         return $this->response->withBody($body);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->autoRender = false;
        $user = $this->Users->findById($id)->first();

        if($user){
            $this->request->allowMethod(['post', 'delete']);
            $user = $this->Users->get($id);
            if ($this->Users->delete($user)) {
                $json = [
                    'error' => 0,
                    'message' => ' Users: Dato eliminado correstamente',
                    'data'=> $user
                ];
                    
        } else {
            $json = [
                'error' => 1,
                'message' => $user->getErrors()
            ];
        }
         } else{
            $json = [
                'error' => 1,
                'message' => 'Dato no encontrado'
            ];
         }      
         $body = $this->response->getBody();
         $body->write(json_encode($json));
         return $this->response->withBody($body);
    }
}
