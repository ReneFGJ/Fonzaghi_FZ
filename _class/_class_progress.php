<?php
class progress
	{
	function radial($agl)
		{
			$angulo = ($agl % 100) * 3.6;
			if (($angulo == 0) and ($agl > 0)) { $angulo = 360; }
			if ($angulo == 100) { $angulo = 360; }
						
			if ($angulo < 180)
				{
					$correcao_x = 90;
					$correcao_y = $angulo + 90;
					$cor = '#2f3439';
				} else {
					$cor = '#ff6347';
					$correcao_x = $angulo - 270;
					$correcao_y = 270;					
				}

			if ($correcao_x > 360) { $correcao_x = $correcao_x - 360; }
			if ($correcao_y > 360) { $correcao_y = $correcao_y - 360; }
			
			$style = 'background-image: 
						linear-gradient('.
						$correcao_x.
						'deg, '.$cor.' 50%, rgba(0, 0, 0, 0) 50%, rgba(0, 0, 0, 0)), 
						linear-gradient('.
						$correcao_y.
						'deg, #ff6347 50%, #2f3439 50%, #2f3439);';
			$sx = 
			'
			<div class="progress-radial" style="'.$style.'">
	  			<div class="overlay">'.$agl.'%</div>
			</div>	
			';
			return($sx);
		}	
	}
?>