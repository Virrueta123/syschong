<?php 
 function method()
  {
      return Config::get('app.cipher');
  }

   function hash_key()
  {
      return hash('sha256', Str::substr(Config::get('app.key'), 7));
  }

   function iv()
  {
      $secret_iv = Str::substr(Config::get('app.key'), 7);
      $iv = substr(hash('sha256', $secret_iv), 0, 16);

      return $iv;
  } 

function encrypt_id($value)
{
 
    $output = openssl_encrypt($value, method(), hash_key(), 0, iv());
    $output = base64_encode($output);

    return $output;
}

function decrypt_id($value)
{ 
    $output = openssl_decrypt(base64_decode($value), method(), hash_key(), 0, iv());
    return (int)$output;
}

function separateDigitsWithHyphen($number) {
    // Asegurarse de que el número tenga exactamente 9 dígitos
    $number = str_pad($number, 9, '0', STR_PAD_LEFT);

    // Separar cada tres dígitos con un guión
    $formattedNumber = substr($number, 0, 3) . '-' . substr($number, 3, 3) . '-' . substr($number, 6);

    return $formattedNumber;
}
 
function mesActual(){     
   return CarbonCarbon::now()->isoFormat('MM'); 
}

function mesyanotext(){
   return CarbonCarbon::now()->isoFormat("MMMM Y"); 
}

function mesActualtext(){ 
    return CarbonCarbon::now()->isoFormat('MMMM');
}

function anoActual(){   
   return CarbonCarbon::now()->format('Y');
}

function fechaactualText(){  
   return CarbonCarbon::now()->isoFormat("D \D\E MMMM Y");
}

function fechaactual(){    
   return CarbonCarbon::now()->format('Y-m-d');
} 
function moneyformat($money){
   return number_format($money, 2, '.', ',');
}

function generarNumeroConsecutivo() {
    static $numero = 1;
    return str_pad($numero++, 8, '0', STR_PAD_LEFT);
}