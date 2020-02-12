<?php 
	error_reporting(E_ALL & ~E_NOTICE);
    ini_set('display_errors', 1);
    function excepHandler($exception) {
        header('HTTP/2 500 Internal server error');
	    echo json_encode(['error' => $exception->getMessage()."<br/>".$exception->getFile().':'.$exception->getLine()."<br/>".$exception->getTraceAsString()."<br/>"]);
        exit();
	}
    function errHandler($level, $message, $file, $line, $context) {
        switch ($level) {
            case E_WARNING:
                $type = 'Warning';
                break;
            case E_NOTICE:
                $type = 'Notice';
                break;
            default;
                return false;
        }
        header('HTTP/2 500 Internal server error');
        echo json_encode(['error' => "<h2>$type: $message</h2><p><strong>File</strong>: $file:$line</p><p><strong>Context</strong>: $". join(', $', array_keys($context))."</p>"]);
        exit();
    }
    set_error_handler('errHandler', E_ALL);
    set_exception_handler('excepHandler');