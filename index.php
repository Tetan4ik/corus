<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>


    <title>Hello, world!</title>
</head>
<body>
<div class="container">

    <?
    require_once "component.php";
    ?>

    <h1>Hello!</h1>
    <div class="row">
        <div class="col-md-2"></div>

        <div class="col-md-8">

            <form name="thanks-report" method="get" action="">
                <div class="form-group">
                    <label for="date-thanks">Date thanks</label>
                    <input type="text" class="form-control date-range" name="date-thanks" id="date-thanks">
                </div>
                <div class="form-group">
                    <label for="department">Department</label>
                    <select class="form-control" name="department" id="department">

                        <option value="">Select</option>

                        <? foreach ($arDepartment as $item) : ?>

                            <option <?= $arParams['department'] == $item->getId() ? 'selected' : '' ?>
                                    value="<?= $item->getId() ?>"><?= $item->getName() ?></option>

                        <? endforeach; ?>

                    </select>
                </div>
                <div class="form-group">
                    <label for="who-say">Who say</label>
                    <input type="text" class="form-control" name="who-say" value="<?= $arParams['whoSay'] ?>"
                           id="who-say">
                </div>
                <div class="form-group">
                    <label for="whom-say">Whom say</label>
                    <input type="text" class="form-control" name="whom-say" value="<?= $arParams['whomSay'] ?>"
                           id="whom-say">
                </div>
                <button type="submit" name="send" value="Y" class="btn btn-primary">Submit</button>
                <button type="submit" class="btn btn-secondary">Reset</button>
            </form>

            <div class="col-md-2"></div>
        </div>

    </div>
    <?if(isset($data['ITEMS'])):?>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-borderless table-responsive-md">
                <thead>
                <th>User</th>
                <th>Count thanks</th>
                </thead>
                <?foreach ($data['ITEMS'] as $arItem): ?>

                    <tr>
                        <td><?= $arItem['name'] ?></td>
                        <td><?= $arItem['count'] ?></td>
                    </tr>

                <? endforeach; ?>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="justify-content-lg-center pagination">

                <?

                $countPages = ceil($data['TOTAL_ITEMS']/$data['PAGE_SIZE']);
                $curPage = $arParams['current_page'];


                if($countPages > 9 && $curPage >= 9):?>

                    <?$arParams['current_page'] = 1?>

                    <a href="?<?=http_build_query($arParams)?>" class="page-link">1</a>

                    <?for ($i = $curPage-4; $i<=$curPage+4;$i++):?>

                    <?$arParams['current_page'] = $i?>

                        <a href="?<?=http_build_query($arParams)?>" class="page-link"><?=$i?></a>

                    <?endfor;?>


                    <?$arParams['current_page'] = $countPages?>

                    <a href="?<?=http_build_query($arParams)?>" class="page-link"><?=$countPages?></a>

                <?elseif($curPage < 9):?>

                    <?for ($i = 1; $i<= 9;$i++):?>

                        <?$arParams['current_page'] = $i?>

                        <a href="?<?=http_build_query($arParams)?>" class="page-link"><?=$i?></a>

                    <?endfor;?>


                    <?$arParams['current_page'] = $countPages?>

                    <a href="?<?=http_build_query($arParams)?>" class="page-link"><?=$countPages?></a>

                <?else:?>

                    <?for ($i = 1; $i<= $countPages;$i++):?>

                        <?$arParams['current_page'] = $i ?>

                        <a href="?<?=http_build_query($arParams)?>" class="page-link"><?=$i?></a>

                    <?endfor?>

                <?endif;?>

            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
    <?endif;?>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>

        $(document).ready(function () {

            var $dateRange = $('.date-range');
            var format = 'DD MMMM YYYY H:mm';

            $dateRange.daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: format
                },
                timePicker: true,
                timePicker24Hour: true
            });

            $dateRange.on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format(format) + ' - ' + picker.endDate.format(format));
            });

            $dateRange.on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });

            <?if($arParams['date-thanks'][0] && $arParams['date-thanks'][1]):?>
            $dateRange.val("<?=date("d F Y H:m", strtotime($arParams['date-thanks'][0]))?> - <?=date("d F Y H:m", strtotime($arParams['date-thanks'][1]))?>");
            <?endif;?>

        });

    </script>
</body>
</html>