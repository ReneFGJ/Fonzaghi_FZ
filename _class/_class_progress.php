<?php
class progress
	{	
	var $agl;
	
	function __construct()
		{
			$this->agl = 0;
		}
		
	function radial($agl=0)
		{
			if(trim(round($agl))==0){ $agl=$this->agl; }
				
			$angulo = ($agl % 100) * 3.6;
			if (($angulo == 0) and ($agl > 0)) { $angulo = 360; }
			if ($angulo == 100) { $angulo = 360; }
						
			if ($angulo < 180)
				{
					$correcao_x = 90;
					$correcao_y = $angulo + 90;
					$cor = '#FFFFFF';
				} else {
					$cor = '#61c2d0';
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
						'deg, #61c2d0 50%, #FFFFFF 50%, #FFFFFF);';
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