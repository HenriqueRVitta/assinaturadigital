<?php
//Caminho do Certificado
#$pfxCertPrivado = 'E:\Dados_Empresa\Certificado\certificado.pfx';
$pfxCertPrivado = 'certificado.pfx';
$cert_password  = '123456';

if (!file_exists($pfxCertPrivado)) {
   echo "Certificado não encontrado!! " . $pfxCertPrivado;
}

$pfxContent = file_get_contents($pfxCertPrivado);

if (!openssl_pkcs12_read($pfxContent, $x509certdata, $cert_password)) {
   echo "O certificado não pode ser lido!!";
} else {

   $CertPriv   = array();
   $CertPriv   = openssl_x509_parse(openssl_x509_read($x509certdata['cert']));

   $PrivateKey = $x509certdata['pkey'];

   $pub_key = openssl_pkey_get_public($x509certdata['cert']);
   $keyData = openssl_pkey_get_details($pub_key);

   $PublicKey  = $keyData['key'];

   echo '<br>'.'<br>'.'--- Dados do Certificado ---'.'<br>'.'<br>';
   echo $CertPriv['name'].'<br>';                           //Nome
   echo $CertPriv['hash'].'<br>';                           //hash
   echo $CertPriv['subject']['C'].'<br>';                   //País
   echo $CertPriv['subject']['ST'].'<br>';                  //Estado
   echo $CertPriv['subject']['L'].'<br>';                   //Município
   echo $CertPriv['subject']['CN'].'<br>';                  //Razão Social e CNPJ / CPF
   echo date('d/m/Y', $CertPriv['validTo_time_t'] ).'<br>'; //Validade
   echo $CertPriv['extensions']['subjectAltName'].'<br>';   //Emails Cadastrados separado por ,
   echo $CertPriv['extensions']['authorityKeyIdentifier'].'<br>'; 
   echo $CertPriv['issuer']['OU'].'<br>';                   //Emissor 
   echo '<br>'.'<br>'.'--- Chave Pública ---'.'<br>'.'<br>';
   print_r($PublicKey);
   echo '<br>'.'<br>'.'--- Chave Privada ---'.'<br>'.'<br>';
   echo $PrivateKey;
}
?>
