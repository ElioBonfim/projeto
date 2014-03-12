<?php

class Neo_View_Helper_CheckImg

{

	public function CheckImg($img){

		

		if(file_exists('http://localhost'.$img)){			

			echo '<img src="'.$img.'"/>';

		} 

		

	}

}

