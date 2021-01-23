<h1>Ceci est le shop</h1>
<?php
foreach ($devs as $dev): ?>
<h2><a href="/shop/details/<?= $dev["dev_id"] ?>"><?= $dev["dev_name"] ?></a></h2>
<p><?= $dev["dev_description"] ?></p>
<?php endforeach; ?>