<?php
class Socket {

    var $socket;
    var $sendflag = ">>>";
    var $recvflag = "<<<";
    var $response;
    var $debug = 0;

    function socket($hostname, $port) {
        $address = gethostbyname($hostname);
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $result = socket_connect($this->socket, $address, $port);
        if ($this->debug == 1) {
            if ($result < 0) {
                echo "socket_connect() failed.\nReason: ($result) " . socket_strerror($result);
            } else {
                echo "connect OK";
            }
        }
    }

    function sendmsg($msg) {
        socket_write($this->socket, $msg, strlen($msg));
        $result = socket_read($this->socket, 100);
        $this->response = $result;
        if ($this->debug == 1) {
            echo '<font color="#cccccc">'.$this->sendflag.'</fon>';
            echo '<font color="blue">'.$this->recvflag.'</font>';
        }
        return $result;
    }

    function close() {
        socket_close($this->socket);
    }

}
?>
