<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Donation[]|\Cake\Collection\CollectionInterface $donations
 */
?>

<button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#donationModal">New donation</button>

<div class="modal fade" id="donationModal" tabindex="-1" aria-labelledby="donationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- <form action="(/donations/add)" method="post"> -->
                <div class="modal-header">
                    <h5 class="modal-title" id="donationModalLabel">Donation form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="donations form large-9 medium-8 columns content">
                        <?= $this->Form->create('donations', ['url' => ['action' => 'add']]) ?>
                        <fieldset>
                            <legend><?= __('Add Donation') ?></legend>
                            <?php
                            echo $this->Form->control('donator_name');
                            echo $this->Form->control('email');
                            echo $this->Form->control('amount');
                            echo $this->Form->control('message');
                            ?>
                        </fieldset>
                        <button type="submit" class="btn btn-primary" name="save">Save</button>
                        <!-- <?= $this->Form->button(__('Submit')) ?> -->
                        <?= $this->Form->end() ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" name="save" class="btn btn-primary">Save</button> -->
                </div>
            <!-- </form> -->
        </div>
    </div>
</div>

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="card m-2" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Total donation for last month: </h5>
                <p class="card-text"><?php echo $lastMonthDonations->sum ?> грн</p>
            </div>
        </div>
        <div class="card m-2" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Top donator: </h5>
                <p class="card-text"><?php echo $biggestDonation->donator_name ?></p>
                <h5 class="card-title">Donated: </h5>
                <p class="card-text"><?php echo $biggestDonation->amount ?> грн</p>
            </div>
        </div>
        <div class="card m-2" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Total donations: </h5>
                <p class="card-text"><?php echo $sumDonations->sum ?> грн</p>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
    <div id="curve_chart" style="width: 900px; height: 500px"></div>
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
                    <th scope="col"><?= $this->Paginator->sort('message') ?></th>
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
                        <td><?= h($donation->message) ?></td>
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

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Date', 'Donations'],
            ['2004', 1000],
            ['2005', 1170],
            ['2006', 660],
            ['2007', 1030]
        ]);

        var options = {
            title: 'Donations Chart',
            curveType: 'function',
            legend: {
                position: 'bottom'
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
    }
</script>