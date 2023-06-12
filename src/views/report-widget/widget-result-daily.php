<?php

use Yii;
?>

<div class="table-responsive text-nowrap" style="direction: rtl;">
    <table class="table bg-white">
        <thead class="table-dark">
        <tr class="text-left">
            <th>#</th>
            <?php foreach ($runWidget->add_on['result'] as $item): ?>
                <th><?= $item['year']."/".$item['month']."/".$item['day']; ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <tr class="text-left">
            <th>
                شروع:
                <?= Yii::$app->pdate->jdate('Y/m/d',$runWidget->start_range); ?>
                <br />
                پایان:
                <?= Yii::$app->pdate->jdate('Y/m/d',$runWidget->end_range); ?>
            </th>
            <?php foreach ($runWidget->add_on['result'] as $item): ?>
                <th>
                    تعداد:
                    <?= $item['total_count']; ?>
                    <br />
                    مجموع:
                    <?= $item['total_amount']; ?>
                </th>
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
                    "<?= $item['year']."/".$item['month']."/".$item['day']; ?>",
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


