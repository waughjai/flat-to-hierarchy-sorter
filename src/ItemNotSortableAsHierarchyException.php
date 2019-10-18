<?php

declare( strict_types = 1 );
namespace WaughJ\FlatToHierarchySorter;

class ItemNotSortableAsHierarchyException extends \InvalidArgumentException
{
    public function __construct( $arg )
    {
        $typename = gettype( $arg );
        if ( $typename === 'object' )
        {
            $classname = get_class( $arg );
            if ( $classname )
            {
                $typename = $classname;
            }
        }
        parent::__construct( "Argument to FlatToHierarchySorter is not a sortable HierarchicalNode item but a {$typename}" );
    }
}