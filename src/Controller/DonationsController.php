<?php

namespace App\Controller;

use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
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

        $lastMonth = (new Time('first day of previous month'))->i18nFormat('yyyy-MM-dd');
        $nextMonth = (new Time('last day of previous month'))->i18nFormat('yyyy-MM-dd');
        $lastMonthDonationsQuery = $this->Donations->find();
        $lastMonthDonations = $lastMonthDonationsQuery->select(['sum' => $lastMonthDonationsQuery->where(['created >=' => $lastMonth, 'created <=' => $nextMonth])->func()->sum('amount')])->first();

        $biggestDonation = $this->Donations->find()->select(['amount', 'donator_name'])->order(['amount' => 'DESC'])->first();

        $sumDonationsQuery = $this->Donations->find();
        $sumDonations = $sumDonationsQuery->select(['sum' => $sumDonationsQuery->func()->sum('amount')])->first();

        $queryChart = $this->Donations->find();
        $charts = $queryChart->select([
            'date' => 'DATE(created)',
            'amount' => $queryChart->func()->sum('amount')
        ])
            ->group('date')
            ->order(['date' => 'ASC'])
            ->all()
            ->map(function ($row) {
                return [$row->date, (int) $row->amount];
            })
            ->toArray();

        $this->set(compact('donations', 'biggestDonation', 'sumDonations', 'lastMonthDonations', 'charts'));
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
                // $this->Flash->success(__('The donation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            // $this->Flash->error(__('The donation could not be saved. Please, try again.'));
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
