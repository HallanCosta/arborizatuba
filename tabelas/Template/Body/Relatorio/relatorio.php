<th scope="row"><?=$value->id;?></th>
<td class="text-center"><?=$value->cep;?></td>
<td class="text-center"><?=$value->tp_logradouro;?></td>
<td class="text-center"><?=$value->logradouro;?></td>
<td class="text-center"><?=$value->num;?></td>
<td class="text-center"><?=$value->complemento;?></td>
<td class="text-center"><?=$value->bairro;?></td>
<td class="text-center"><?=$value->especie;?></td>
<td class="text-center"><?=$value->porte;?></td>
<td class="text-center"><?=$value->quant;?></td>
<td class="text-center"><?=DateTime::createFromFormat('Y-m-d', $value->ult_poda)->format('d/m/Y');?></td>
<td class="text-center"><?=DateTime::createFromFormat('Y-m-d', $value->prox_poda)->format('d/m/Y');?></td>
<td class="text-center hidden-print"><a href="../../<?=$value->urlFoto;?>?id_arvore=<?=$value->id;?>" target="_blank">Link</a></td>

