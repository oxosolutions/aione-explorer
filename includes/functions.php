<?php
function scan($dir){

	$files = array();

	// Is there actually such a folder/file?

	if(file_exists($dir)){
	
		foreach(scandir($dir) as $f) {
		
			if(!$f || $f[0] == '.') {
				continue; // Ignore hidden files
			}

			if(is_dir($dir . '/' . $f)) {

				// The path is a folder

				$files[] = array(
					"name" => $f,
					"type" => "folder",
					"path" => $dir . '/' . $f,
					"items" => scan($dir . '/' . $f) // Recursively get the contents of the folder
				);
			}
			
			else {

				// It is a file

				$files[] = array(
					"name" => $f,
					"type" => "file",
					"path" => $dir . '/' . $f,
					"size" => filesize($dir . '/' . $f) // Gets the size of this file
				);
			}
		}
	
	}

	return $files;
}

function clean_class($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
   $string = preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
   $string = trim($string, '-'); // Remove first or last -
   $string = strtolower($string); // lowercase

   return $string;
}


function aione_data_table($headers, $data, $id='aione-',$class = 'compact'){  
    $columns = array();
    foreach ($headers as $key => $header){
        $columns[] = clean_class($header);
    }

    $output = "";
    $output .= '<div class="aione-search aione-table" >';
    $output .= '<div class="field">';
    $output .= '<input autofocus type="text" class="aione-search-input" data-search="'.implode(' ',$columns).'" placeholder="Search">';
    $output .= '</div>';
    $output .= '<div class="clear"></div>';
    $output .= '<table class="'.$class.'">';
    $output .= '<thead>';
    $output .= '<tr>';
    foreach ($headers as $key => $header){
        $output .= '<th class="aione-sort-button" data-sort="'.$columns[$key].'">'.$header.'</th>';
    }
    $output .= '</tr>';
    $output .= '</thead>';
    $output .= '<tbody class="aione-search-list">';
    if(!empty($data)){
        foreach ($data as $record_key => $record){
            $output .= '<tr>';
            foreach ($record as $key => $value){
                $output .= '<td class="'.$columns[$key].'">'.$value.'</td>';
            }
            $output .= '</tr>';
        }
    }
    $output .= '</tbody>';
    $output .= '</table>';
    $output .= '</div>';
    return $output;
}