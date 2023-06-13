<?php


?>

<div class="table-responsive text-nowrap" style="direction: rtl;">
    <table class="table bg-white">
        <thead class="table-dark">
        <tr class="text-left">
            <?php foreach ($runWidget->add_on['result'] as $item): ?>
                <th><?= $item['month_name']; ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <tr class="text-left">
            <?php foreach ($runWidget->add_on['result'] as $item): ?>
                <th><?= $item['total_count']; ?></th>
            <?php endforeach; ?>
        </tr>

        </tbody>
        <tbody>
        <tr  class="text-left">
            <?php foreach ($runWidget->add_on['result'] as $item): ?>
                <th><?= $item['total_amount']; ?></th>
            <?php endforeach; ?>
        </tr>

        </tbody>
    </table>
</div>
