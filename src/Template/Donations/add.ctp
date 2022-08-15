<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Donation $donation
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Donations'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="donations form large-9 medium-8 columns content">
    <?= $this->Form->create($donation) ?>
    <fieldset>
        <legend><?= __('Add Donation') ?></legend>
        <?php
            echo $this->Form->control('donator_name');
            echo $this->Form->control('email');
            echo $this->Form->control('amount');
            echo $this->Form->control('message');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
