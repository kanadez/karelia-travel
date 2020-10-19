<?php
                     
$ftp_server = "77.222.42.204";
$ftp_user = "nespizdiru";
$ftp_pass = ".C[tVx{Gk2Ecd|q7gmm";

// set up a connection or die
$conn_id = ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server"); 

// try to login
if (@ftp_login($conn_id, $ftp_user, $ftp_pass)) {
    echo "Connected as $ftp_user@$ftp_server\n";
} else {
    echo "Couldn't connect as $ftp_user\n";
}

$dir = "/posportu/public_html/app/public_html/admin/upload/ftp/gg";

if (ftp_mkdir($conn_id, $dir)) {
 echo "successfully created $dir\n";
} else {
 echo "There was a problem while creating $dir\n";
}

// close the connection
ftp_close($conn_id);  
?>