<?php 
	$question = $data->listQuestion();
	$answer = $data->listAnswer();
 ?>
 <form action="" method="post">
	{each $question as $valueQue}
	{valueQue[name]} ?<br />
	{each $answer as $valueAns}
	<?php 
	 	$tab = '&nbsp;&nbsp;&nbsp;&nbsp;';
	 	if($valueAns['questionId'] == $valueQue['id'])
	 	{
	 		if($valueAns['valueTrue'] == 1)
	 		{
	 			echo $tab.'<input type="radio" name="'.$valueAns['questionId'].'" value="'.$valueAns['id'].'" placeholder="" disabled checked/> '.$valueAns['value'].'.<br />';
	 		}
	 		echo $tab.'<input type="radio" name="'.$valueAns['questionId'].'" value="'.$valueAns['id'].'" placeholder="" disabled/> '.$valueAns['value'].'.<br />';
	 	}
	?>
	{/each}
	{/each}
 </form>