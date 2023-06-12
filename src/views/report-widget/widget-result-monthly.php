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
<div class="col bg-white">
    <div>
        <canvas id="myChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('myChart');

        const mixedChart = new Chart(ctx, {
            data: {
                datasets: [
                    {
                        type: 'bar',
                        label: 'Bar Dataset',
                        data: [
                            <?php foreach ($runWidget->add_on['result'] as $item): ?>
                            <?= $item['total_amount']; ?>,
                            <?php endforeach; ?>
                        ],
                    },
                    {
                        type: 'line',
                        label: 'line Dataset',
                        data: [
                            <?php foreach ($runWidget->add_on['result'] as $item): ?>
                            <?= $item['total_amount']; ?>,
                            <?php endforeach; ?>
                        ],
                    }
                ],
                labels: [
                    <?php foreach ($runWidget->add_on['result'] as $item): ?>
                    "<?= $item['year']."/".$item['month']; ?>",
                    <?php endforeach; ?>
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });



    </script>

</div>

