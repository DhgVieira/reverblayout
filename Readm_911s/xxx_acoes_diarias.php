<?php
require_once 'ProdutoDia.php';

$ObjProdutoDia = new ProdutoDia('production');
$ObjProdutoDia->clearMemCached = true;
$ObjProdutoDia->exec();