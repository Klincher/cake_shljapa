<?php

namespace App\Controller;

use Cake\ORM\Query;
use App\Controller\AppController;
use Cake\I18n\Time;

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

        //  $this->model->where('created_at', '>=', Carbon::now()->startOfMonth()->subMonthsNoOverflow())
        //     ->where('created_at', '<=', Carbon::now()->subMonthsNoOverflow()->endOfMonth())
        //     ->sum('amount');

        $lastMonth = (new Time('first day of previous month'))->i18nFormat('yyyy-MM-dd');
        $nextMonth = (new Time('last day of previous month'))->i18nFormat('yyyy-MM-dd');

        $lastMonthDonations = $this->Donations->find();

        $lastMonthDonations = $lastMonthDonations->select(['sum' => $lastMonthDonations->where(['created >=' => $lastMonth, 'created <=' => $nextMonth])->func()->sum('amount')])->first();

        $biggestDonation = $this->Donations->find()->select(['amount', 'donator_name'])->order(['amount' => 'DESC'])->first();

        $sumDonationsQuery = $this->Donations->find();
        $sumDonations = $sumDonationsQuery->select(['sum' => $sumDonationsQuery->func()->sum('amount')])->first();

        $this->set(compact('donations', 'biggestDonation', 'sumDonations', 'lastMonthDonations'));
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
