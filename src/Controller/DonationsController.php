<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Donations Controller
 *
 * @property \App\Model\Table\DonationsTable $Donations
 *
 * @method \App\Model\Entity\Donation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DonationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $donations = $this->paginate($this->Donations);

        $query = $this->Donations->find();
        $biggestDonation = $query->select(['amount' => $query->func()->max('amount')])->first();

        $this->set(compact('donations', 'biggestDonation'));
    }

    /**
     * View method
     *
     * @param string|null $id Donation id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $donation = $this->Donations->get($id, [
            'contain' => [],
        ]);

        $this->set('donation', $donation);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $donation = $this->Donations->newEntity();
        if ($this->request->is('post')) {
            $donation = $this->Donations->patchEntity($donation, $this->request->getData());
            if ($this->Donations->save($donation)) {
                $this->Flash->success(__('The donation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The donation could not be saved. Please, try again.'));
        }
        $this->set(compact('donation'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Donation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $donation = $this->Donations->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $donation = $this->Donations->patchEntity($donation, $this->request->getData());
            if ($this->Donations->save($donation)) {
                $this->Flash->success(__('The donation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The donation could not be saved. Please, try again.'));
        }
        $this->set(compact('donation'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Donation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $donation = $this->Donations->get($id);
        if ($this->Donations->delete($donation)) {
            $this->Flash->success(__('The donation has been deleted.'));
        } else {
            $this->Flash->error(__('The donation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
