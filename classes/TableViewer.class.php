<?php

class TableViewer {

	private function __construct(){}

	public static function getTableHTML($cache){

		/*
		 * Table headings:
                 *   - key
                 *   - slab
                 *   - size
                 *   - expiration time
                 *   - expires in
		 */

		$current_time = time();
		$output = 'Refresh after: <b id="counter"></b> second';
		$output .= '<table id="TableViewer"><tr><th>Key</th><th>Slab</th><th>Size</th><th>Expiration Time</th><th>Expires In</th><th><a href="delete_all.php">Delete ALL</a></th></tr>';
		$output .= '
			<script>
				counter = Number(document.getElementById("refresh_rate").value)
				document.getElementById("counter").innerHTML = counter;
				function openWin(key) {
					var url = "value.php?key=" + encodeURIComponent(key);
					var clientWidth = document.documentElement.clientWidth;
					var clientHeight = document.documentElement.clientHeight;
					myWindow = window.open(url, "memcache_value" ,"width=" + (clientWidth - 200) + ",height=" + (clientHeight - 100) + ",left=" + (clientWidth/2 - (clientWidth - 200)/2) + ", top=" + (clientHeight/2 - (clientHeight - 100)/2) + ",scrollbars=yes,resizable=yes,location=no,fullscreen=no,menubar=no,status=no,titlebar=no,toolbar=no");
					myWindow.focus();				
				}
				
			</script>
		';	
		foreach ($cache->items as $item){
			$item_value_piece = $item->getValuePiece();
			if (strlen($item_value_piece) == 500) {
				$item_value_piece = '<font class="html_value_piece_color">' . $item_value_piece . '</font>...';
			} else {
				$item_value_piece = '<font class="html_value_color">' . $item_value_piece . '</font>';
			}

			$output .= '<tr>';

			$output .= '<td class="key"><font class="key_color">' . $item->getKey() . '</font><br>' . $item_value_piece . '</td>';
			$output .= '<td class="slab">' . $item->getSlab() . '</td>';
			$output .= '<td class="size"><a href="javascript: openWin(\'' . $item->getKey() . '\');" title="Show value...">' . $item->getSize() . '</a></td>';
			$output .= '<td class="expiry_date">' . $item->getFormattedTime() . '</td>';
			$output .= '<td class="expires_in">' . $item->getFormattedTime($current_time) . '</td>';
			$output .= '<td class="delete"><a href="delete.php?delete_item=' . urlencode($item->getKey()) . '">delete</a></td>';

			$output .= '</tr>';

		}//foreach

		$output .= '</table>';

		return $output;

	}//getTableHTML

}//Tableiewer


?>
