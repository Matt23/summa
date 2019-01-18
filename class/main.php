<?php

class main {

    private $sec;
    private $tpl;
    private $mysql;

    function __construct() {

        $this->tpl = new tplClass();
        $this->mysql = new mysql();
    }

    function notFound() {

        header('Content-Type: text/html; charset=ISO-8859-1');

        $datos['path'] = INSTALLPATH;
        $datos['titulo'] =' Summa';
        $datos['description'] ='';
        $datos['keywords'] ='';
        $datos['error'] ='';

        echo $this->tpl->printTemplate("notFound", $datos);
    }

    function header($dat) {
        $datos["titulo"]="";
        echo $this->tpl->printTemplate("header", $datos);
    }
	
    function footer() {
        $datos["firma"] = "";
        echo $this->tpl->printTemplate("footer", $datos);
    }

    function token($length=24) {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str='';
        $size = strlen($chars);
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0,$size-1)];
        }
        return $str;
    }

    function enviarCorreo($asunto, $msg, $from=mailFrom, $to=mailTo) {

        try {

            $mail = new phpMailer(true);

            $mail->Mailer   = mailMailer;
            $mail->Host     = mailHost;
            $mail->SMTPAuth = mailAuth;
            $mail->Username = mailUsername; 
            $mail->Password = mailPassword;

            $mail->From     = mailFrom;
            $mail->FromName = mailFromName;
            $mail->AddAddress(mailTo);

            $mail->Timeout = 30;

            $mail->Subject = $asunto;
            $mail->Body    = $msg;

            $mail->ContentType = "text/html";

            $exito = $mail->Send();

            $intentos=1; 

            while ((!$exito) && ($intentos < 5)) {

                sleep(5);
                $exito = $mail->Send();
                $intentos=$intentos+1;  
            }
            if ($exito) {

                // echo "Ok.<br>";

            } else {

                echo($mail->ErrorInfo);
            }

        } catch (phpmailerException $e) {

          echo $e->errorMessage();

        } catch (Exception $e) {

          echo $e->getMessage();
        }
    }

  
    function format_uri($string, $separator = '-') {
        setlocale(LC_ALL, 'en_US.UTF8');
        $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
        $special_cases = array( '&' => 'and');
        $string = mb_strtolower( trim( $string ), 'UTF-8' );
        $string = str_replace( array_keys($special_cases), array_values( $special_cases), $string );
        $string = preg_replace( $accents_regex, '$1', htmlentities( $string, ENT_QUOTES, 'UTF-8' ) );
        $string = preg_replace("/[^a-z0-9]/u", "$separator", $string);
        $string = preg_replace("/[$separator]+/u", "$separator", $string);
        return $string;
    }

    function base64_url_encode($input) {
     return strtr(base64_encode($input), '+/=', '-_.');
    }

    function base64_url_decode($input) {
     return base64_decode(strtr($input, '-_.', '+/='));
    }

    function enviarbase64($post=null) {

        $getencode = $this->base64_url_encode($post['Nombre'].'&'.$post['Apellido'].'&'.$post['DNI'].'&'.$post['cel'].'&'.$post['Email'] );
        header('location:http://www.remotesite.com/registro.php?getencode='.$getencode);
        exit();
    }

    function recibirbase64($get=null) {

        $datos = split('&', $this->base64_url_decode($get['getencode']));

        $infomail['Nombre'] = $datos['0'] ;
        $infomail['Apellido'] = $datos['1'] ;
        $infomail['DNI'] = $datos['2'] ;
        $infomail['cel'] = $datos['3'] ;
        $infomail['Email'] = $datos['4'] ;

        return $infomail;
    }

    function getFullURL() {
        $url = isset($_SERVER['HTTPS']) ? "https" : "http" . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        return $url;
    }

    function getClientIP() {
        $ipaddress = 'UNKNOWN';
        $ipaddress =  getenv('REMOTE_ADDR')             ? getenv('REMOTE_ADDR')             : $ipaddress ;
        $ipaddress =  getenv('HTTP_FORWARDED')          ? getenv('HTTP_FORWARDED')          : $ipaddress ;
        $ipaddress =  getenv('HTTP_FORWARDED_FOR')      ? getenv('HTTP_FORWARDED_FOR')      : $ipaddress ;
        $ipaddress =  getenv('HTTP_X_FORWARDED')        ? getenv('HTTP_X_FORWARDED')        : $ipaddress ;
        $ipaddress =  getenv('HTTP_X_FORWARDED_FOR')    ? getenv('HTTP_X_FORWARDED_FOR')    : $ipaddress ;
        $ipaddress =  getenv('HTTP_CLIENT_IP')          ? getenv('HTTP_CLIENT_IP')          : $ipaddress ;
        return $ipaddress;
    }

    function validateDate($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function limpiarSTR($texto,$limpiar) { 
        // Deja una sola ocurrencia "limpiar" en el "texto" que se le pase.
        // Ejemplo: limpiando '<br>', Hola<br><br><br> quedaría como Hola<br>.
        for ($i = substr_count($texto, $limpiar) ; $i >=2 ; $i--) { 
            for ($j=1; $j <= $i ; $j++) { 
                $tmp .= $limpiar;
            }
            $texto = str_replace($tmp,$limpiar,$texto);
            $tmp = '';
        }
        return $texto;
    }

    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    function DBQuery($datos) { 

        try {

            $sql = "INSERT INTO tabla (nombre, apellido) 
                    values(:nombre, :apellido);";

            $stmt = $this->mysql->query()->prepare($sql);
            $stmt->bindParam(':nombre', htmlentities(trim($datos['Nombre'])), PDO::PARAM_STR);  
            $stmt->bindParam(':apellido', htmlentities(trim($datos['Apellido'])), PDO::PARAM_STR); 

            $stmt->execute();

        } catch(PDOException $e) {
            //echo 'Error: ' . $e->getMessage();
            exit('<br>Error de base de datos.<br>');
        }

        return true;
    }

    function DBpQuery($sql,$datos) { 

        try {

            $stmt = $this->mysql->pQuery($sql, $datos);

        } catch(PDOException $e) {
            //echo 'Error: ' . $e->getMessage();
            exit('<br>Error de base de datos.<br>');
        }

        // Como incluye el fetch, podría hacer un return del stmt y recorrerlo con un foreach ($stmt as $row), un while, etc.
        return true;
    }

    function printPDF($file) {
        // Función que le paso el nombre de un archivo pdf que tengo en el servidor, y lo muestra por pantalla.
        $filename =  $file;
        $filename =  str_replace('%20', ' ', $filename) . '.pdf'; // Reemplazo los espacios, si el nombre viene por la url.
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($filename));
        header('Accept-Ranges: bytes');
        @readfile($filename);
    }

}
?>
