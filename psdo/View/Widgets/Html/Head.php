<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <? foreach ($meta as $key): ?>
    <meta <?=$key?>>
    <? endforeach ?>
    <? foreach ($js as $key): ?>
    <script type="text/javascript" src="<?=$key?>"></script>
    <? endforeach ?>
    <? foreach ($js as $key): ?>
    <link rel="stylesheet" href="<?=$key?>">
    <? endforeach ?>
    <title><?=$title?></title>
    <?=$after?>
</head>
