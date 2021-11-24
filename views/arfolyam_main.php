<script>
    $(function() {
        $("#day").datepicker({
            changeMonth: true,
            changeYear: true,
            minDate: new Date('<?php echo $viewData['FirstDate']; ?>'),
            maxDate: new Date('<?php echo $viewData['LastDate']; ?>'),
        });
        $("#day").datepicker("option", "dateFormat", "yy-mm-dd");
    });
</script>
<form method="post" id="napiForm">
    <div class="row">
        <div class="form-floating mt-3 col-lg-2 mx-auto">
            <input class="form-control" type="text" id="day" name="day">
            <label for="day">Árfolyam nap:</label>
        </div>
    </div>
    <div class="row">
        <div class="form-floating mt-3 col-lg-2 mx-auto">
            <input class="form-control" list="currenciesAvailable" id="currencyDataList" name="currencyDataList">
            <label for="currencyDataList">Adjon meg egy devizát:</label>
            <datalist id="currenciesAvailable">
                <?php foreach ($viewData['currencies'] as $curr) {
                    echo "<option value=\"{$curr}\">";
                } ?>
            </datalist>
        </div>
    </div>
    <div class="row">
        <button type="submit" class="btn btn-primary mx-auto col-lg-1 mt-3">Keresés</button>
    </div>
</form>
<?php if (isset($viewData['currencyDataList']) && isset($viewData['napiArfolyam'])) { ?>
    <div>
        <div class="row">
            <div class="mt-3 col-lg-3 mx-auto">
                <p>
                    <?php if (empty($viewData['napiArfolyam'])) {
                        $currencies = implode(", ", $viewData['currencyDataList']);
                        echo "A megadott napra ({$viewData['day']}) és devizá(k)ra ({$currencies}) nem található árfolyam adat.";
                    } else {
                        $chosen_day = $viewData['napiArfolyam']['Day']['date'];
                        $rates = $viewData['napiArfolyam']['Day']->Rate;
                    ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="mt-3 col-lg-2 mx-auto">
                <table class="table table-hover">
                    <thead>
                        <th>Dátum</th>
                        <?php foreach ($viewData['currencyDataList'] as $currencyName) { ?>
                            <th><?php echo $currencyName; ?></th>
                        <?php } ?>
                    </thead>
                    <tbody>
                        <tr>
                            <?php foreach ($rates as $rate) { ?>
                                <td><?php print($chosen_day); ?></td>
                                <td><?php echo $rate . " HUF"; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
<?php
                            }
                        } ?>
</p>
    </div>
<?php } ?>

<script>
    $(function() {
        $('#month').datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm',
            minDate: new Date('<?php echo $viewData['FirstDate']; ?>'),
            maxDate: new Date('<?php echo $viewData['LastDate']; ?>'),

            onClose: function() {
                var iMonth = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var iYear = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(iYear, iMonth, 1));
            },

            beforeShow: function() {
                if ((selDate = $(this).val()).length > 0) {
                    iYear = selDate.substring(selDate.length - 4, selDate.length);
                    iMonth = jQuery.inArray(selDate.substring(0, selDate.length - 5), $(this).datepicker('option', 'monthNames'));
                    $(this).datepicker('option', 'defaultDate', new Date(iYear, iMonth));
                    $(this).datepicker('setDate', new Date(iYear, iMonth));
                }
            }
        });
    });
</script>
<form method="post" id="haviForm">
    <div class="row">
        <div class="form-floating mt-3 col-lg-2 mx-auto">
            <input class="form-control" type="text" id="month" name="month">
            <label for="month">Árfolyam hónap:</label>
        </div>
    </div>
    <div class="row">
        <div class="form-floating mt-3 col-lg-2 mx-auto">
            <!-- <input class="form-control " id="" name="dailyCurrencyNames">-->
            <input class="form-control" list="currenciesAvailable" id="monthlyCurrencyNames" name="monthlyCurrencyNames">
            <label for="monthlyCurrencyNames">Adjon meg egy devizát:</label>
            <datalist id="currenciesAvailable">
                <?php foreach ($viewData['currencies'] as $curr) {
                    echo "<option value=\"{$curr}\">";
                } ?>
            </datalist>
        </div>
    </div>
    <div class="row">
        <button type="submit" class="btn btn-primary mx-auto col-lg-1 mt-3">Keresés</button>
    </div>
</form>

<?php if (isset($viewData['monthlyCurrencyNames']) && isset($viewData['haviArfolyam'])) { ?>
    <div class="row">
        <div class="mt-3 col-lg-2 mx-auto">
            <table class="table table-hover">
                <thead>
                    <th>Dátum</th>
                    <th><?php echo $viewData['monthlyCurrencyNames']; ?></th>
                </thead>
                <tbody>
                    <?php
                    $ratesForGraphicon = array();
                    foreach ($viewData['haviArfolyam'] as $nap => $xml) { ?>
                        <tr>
                            <td><?php print($xml['date']); ?></td>
                            <?php foreach ($xml->Rate as $rate) {
                                array_push($ratesForGraphicon, str_replace(",", ".", $rate));
                                echo "<td>{$rate} HUF</td>";
                            } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="mt-3 col-lg-6 mx-auto">
            <canvas id="arfolyamChart"></canvas>
        </div>
    </div>
    <script>
        const labels = [
            <?php foreach ($viewData['haviArfolyam'] as $nap => $xml) {
                echo "'{$xml['date']}',";
            } ?>
        ];
        const rateJson = <?php echo json_encode($ratesForGraphicon); ?>;
        const data = {
            labels: labels,
            datasets: [{
                label: <?php echo "'{$viewData['monthlyCurrencyNames']}'"; ?>,
                backgroundColor: 'rgb(87, 76, 70)',
                borderColor: 'rgb(87, 76, 70)',
                data: rateJson,
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {}
        };

        const myChart = new Chart(
            document.getElementById('arfolyamChart'),
            config
        );
    </script>

<?php } ?>