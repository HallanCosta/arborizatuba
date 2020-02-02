<th scope="row"><?=$value->id;?></th>
<td class="text-center col-xl-1"><?=$value->cep;?></td>
<td class="text-center col-xl-1"><?=$value->tp_logradouro;?></td>
<td class="text-center col-xl-1"><?=$value->logradouro;?></td>
<td class="text-center col-xl-1"><?=$value->num;?></td>
<td class="text-center col-xl-1"><?=$value->complemento;?></td>
<td class="text-center col-xl-1"><?=$value->bairro;?></td>
<td class="text-center col-xl-1"><?=$value->especie;?></td>
<td class="text-center col-xl-1"><?=$value->porte;?></td>
<td class="text-center col-xl-1"><?=$value->quant;?></td>
<td class="text-center col-xl-1"><?=DateTime::createFromFormat('Y-m-d', $value->ult_poda)->format('d/m/Y');?></td>
<td class="text-center col-xl-1"><?=DateTime::createFromFormat('Y-m-d', $value->prox_poda)->format('d/m/Y');?></td>
<td class="text-center col-xl-1 hidden-print"><a href="<?=$value->urlFoto;?>">Link</a></td>
