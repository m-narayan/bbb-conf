<?php
/************************************************************************
* 
* Author(s): Satish, Srikanata 
* Descreption: The algorithm will encrypt and decrypt the string with key 
* Modified Date(s):27-Mar-2013, 28-Mar-2013
*  
**************************************************************************/
class EncryptDecrypt {
    
    public function edCrypt($str,$ky='') {
        if($ky=='')return $str;
        
        $ky=str_replace(chr(32),'',$ky);
        
        if(strlen($ky)<8)exit('key error');
        
        $kl=strlen($ky)<32?strlen($ky):32; 
		
        $k=array();for($i=0;$i<$kl;$i++) {
            $k[$i]=ord($ky{$i})&0x1F;
        } 
		$j=0;for($i=0;$i<strlen($str);$i++) {
            $e=ord($str{$i}); 
			$str{$i}=$e&0xE0?chr($e^$k[$j]):chr($e); 
			$j++;$j=$j==$kl?0:$j;
        }
        return $str;
    }
}
?>