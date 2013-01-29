<?php
/**
 * getDiskSpace( $path ) Operator
 * designed to get the disk space on a specified path (total, used and free space) 
 * and return it in an array of formatted strings.
 */
class MugoDiskSpaceOperators
{
    function __construct()
    {
    }

    function operatorList()
    {
        return array( 'getDiskSpace' );
    }

    function namedParameterPerOperator()
    {
        return true;
    }

    function namedParameterList()
    {
        return array( 'getDiskSpace' => array( 'path' => array( 'type' => 'string', 'required' => false, 'default' => '/' ) ) );
    }

    function modify( &$tpl, &$operatorName, &$operatorParameters, &$rootNamespace, &$currentNamespace, &$operatorValue, &$namedParameters )
    {
        switch ( $operatorName )
        {
            case 'getDiskSpace':
            {
                $path = '';
                if( $namedParameters[ 'path' ] )
                {
                    $path = $namedParameters[ 'path' ];
                }

                $total  = @disk_total_space( $path );
                $free   = @disk_free_space( $path );
                $used = false;
                if( $total !== false )
                {
                    $used = $total - $free;
                }
                $operatorValue = array(
                                        'total' => $this->bytesToText( $total ), 
                                        'free'  => $this->bytesToText( $free ), 
                                        'used'  => $this->bytesToText( $used ) 
                                      );
            } break;
        }
    }

    function bytesToText( $bytes )
    {
        if( $bytes === false )
        {
            return 'N/A';
        }

        $sizes = array ( 'KB' => 1024, 'MB' => 1024 * 1024, 'GB' => 1024 * 1024 * 1024, 'TB' => 1024 * 1024 * 1024 * 1024 );
        foreach( $sizes as $unit => $size )
        {
            if( ( $bytes / $size < 1024 ) )
            {
                return number_format( $bytes / $size, 2 ) . ' ' . $unit;
            }
        }
        //default to TB display
        return number_format( $bytes / $sizes[ 'TB' ], 2 ) . ' TB';
    }
}
?>