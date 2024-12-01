<ul class="pagination justify-content-center">
	<?php $page==1?$estilo='disabled':$estilo=''?>
	<?php if (COUNT($rows)>0): ?>
		<li class="page-item <?=$estilo?>"><a class="page-link" href="?page=<?=$page-1?>">Anterior</a></li>
	<?php else: ?>
		<li class="page-item disabled"><a class="page-link" href="?page=">Anterior</a></li>
	<?php endif; ?>
	<?php 
	for ($i=1; $i <= $pages; $i++):
		$page == $i?$estilo='active':$estilo='';
	?>
		<li class="page-item <?=$estilo?>"><a class="page-link" href="?page=<?=$i;?>"><?=$i;?></a></li>
	<?php endfor; ?>
	<?php $page==$pages?$estilo='disabled':$estilo=''?>
	<?php if (COUNT($rows)>0): ?>
		<li class="page-item <?=$estilo;?>"><a class="page-link" href="?page=<?=$page+1?>">Próximo</a></li>
	<?php else: ?>
		<li class="page-item disabled"><a class="page-link" href="?page=">Próximo</a></li>
	<?php endif ?>
</ul>