<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Donation $donation
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Donation'), ['action' => 'edit', $donation->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Donation'), ['action' => 'delete', $donation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $donation->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Donations'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Donation'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="donations view large-9 medium-8 columns content">
    <h3><?= h($donation->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Donator Name') ?></th>
            <td><?= h($donation->donator_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($donation->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($donation->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($donation->amount) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($donation->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($donation->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Message') ?></h4>
        <?= $this->Text->autoParagraph(h($donation->message)); ?>
    </div>
</div>
