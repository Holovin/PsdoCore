<br />Subhost: <?= $sub[0]." (sub: ".(count($sub) - 1).")" ?>;
<br />Controller: <?= $controller == "" ? "[empty]" : $controller ?>;
<br />Controller runs: <?= $controllerReal ?>;
<br />Action: <?= $action == "" ? "[emptry]" : $action ?>;
<br />Params: <?= $params ?>;
<br />Sid: <?= $sid ?>;
<br />PsdoID: <?= $id . "(not developed)" ?>;
<br />Logger:<br />
<pre style="white-space: pre-wrap;"><?= $log ?></pre>
