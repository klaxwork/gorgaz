<?php

use common\components\M;

M::printr('_header');

/** общее верхнее меню для всех страниц КРОМЕ главной*/
?>

<!--Header-->
<header>
	<div class="headerContent">
		<div class="logo"><a href="/"><img src="/images/gorgaz/logo.png"></a></div>
		<form class="search" style="display: none;">
			<input type="text"> <input src="/images/gorgaz/button-search.png" type="image">
		</form>
	</div>
</header>