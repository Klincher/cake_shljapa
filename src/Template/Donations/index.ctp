<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Donation[]|\Cake\Collection\CollectionInterface $donations
 */
?>

<a href="/donations/add" class="btn btn-primary mt-2">New donation</a>

<div class="container">
    <div class="row d-flex justify-content-center">

        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Total donation for last month: </h5>
                <p class="card-text"><?php echo $lastMonthDonations->sum ?></p>
            </div>
        </div>

        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Top donator: </h5>
                <p class="card-text"><?php echo $biggestDonation->donator_name ?></p>
            </div>
        </div>

        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Total donations: </h5>
                <p class="card-text"><?php echo $sumDonations->sum ?></p>
            </div>
        </div>

    </div>
</div>

<div class="d-flex justify-content-center">
    <div class="donations index large-9 medium-8 columns content">
        <h3><?= __('Donations') ?></h3>
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('donator_name') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('amount') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($donations as $donation) : ?>
                    <tr>
                        <td><?= $this->Number->format($donation->id) ?></td>
                        <td><?= h($donation->donator_name) ?></td>
                        <td><?= h($donation->email) ?></td>
                        <td><?= $this->Number->format($donation->amount) ?></td>
                        <td><?= h($donation->created) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $donation->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $donation->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $donation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $donation->id)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('first')) ?>
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
                <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
        </div>
    </div>
</div>