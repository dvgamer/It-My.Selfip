<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td class="conner-lt"></td><td class="border-t"></td><td class="conner-rt"></td></tr>
  <tr><td class="border-l"></td>
  <td class="box_main"><div id="store_game">
    <table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td style="font-family:'Verdana' !important"><?php
		for($i=0;$i<512;$i++) {
			echo chr($i);
			echo "<br>\r\n";
		}
		echo ord('²');
       /* $store = new DriveReader("F:/");		
		foreach($store->ListsFolder() as $folder) {
			$anime = $store->TIS($folder);
			$chk = ord(substr($anime,0,1));
			if($chk>64 && $chk<91)
			{
				echo $anime;
				echo "<br>";
			}
		}*/
		?>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </div></td>
  <td class="border-r"></td></tr>
  <tr><td class="conner-lb"></td><td class="border-b"></td><td class="conner-rb"></td></tr>
</table>