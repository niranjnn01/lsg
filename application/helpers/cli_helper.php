<?php if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 *
 * Run a php command as background process
 * irrespective of the OS we are working on
 *
 * Code inspired by
 * RayJ in in3.php.net/manual/en/function.shell-exec.php
 * wouter99999 at gmail dot com in http://php.net/manual/en/function.exec.php
 * 
 */
function runInBackground( $runCommand, $sLogDestination, $sIniLocation='', $bReturnOutput=false ) {
    
    //$runCommand = 'php -q FULLPATH/FILE.php';`
    
    
    
    
    if( isset($_SERVER['PWD']) ) {
        
        // nix (aka NOT windows)
        
        $runCommand =   "php " .
                        ($sIniLocation ? "-c " . $sIniLocation : "") . " " .
                        $runCommand .
                        ( ! $bReturnOutput ? " >> " . ($sLogDestination ? $sLogDestination : " /dev/null")  : "" ) . 
                        " &";
        
        log_message('info', 'LINUX BG PROCESS -- ' . $runCommand);
        
        $output = shell_exec($runCommand);
        
        log_message('info', 'LINUX OUTPUT -- ' . $output);
        
    } else {
        
        // windows
        
        $sRandomString = str_replace(' ', '', str_replace('.', '', microtime()));
        
        $runCommand =   'start "title' .
                        $sRandomString . '" /B php ' .
                        $runCommand . ' > ' .
                        ($sLogDestination ? $sLogDestination : ' NUL');
        //$runCommand = 'start /B php "'.$runCommand.'" > "'.$sLogDestination.'" 2> "'.$sLogDestination.'"';
        
        log_message('info', 'WINDOWS BG PROCESS -- ' . $runCommand);
        pclose( popen( $runCommand, 'r' ) );
        
    }
    
}