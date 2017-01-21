<?php

class filesystem {
	
	function getSubDirectories($directory) {
		$directoryContents = scandir ( $directory );
		$subdirectories = array ();
		foreach ( $directoryContents as $key => $value ) {
			if (is_dir ( $directory . "/" . $value )) {
				$subdirectories [] = $directory . "/" . $value;
			}
		}
		unset ( $directoryContents );
		return $subdirectories;
	}

}