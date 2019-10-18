<?php

declare( strict_types = 1 );
namespace WaughJ\FlatToHierarchySorter;

class FlatToHierarchySorter
{
//
//  PUBLIC
//
/////////////////////////////////////////////////////////

	public function __construct()
	{
	}

	public static function sort( array $in ) : array
	{
		$out = [];

		// Get parent menu items. Delete parent items from $input_list.
		$out = self::getMenuTopLevel( $in );

		// Realign input data to clear out deleted indices.
		$in = array_values( $in );

		// Get children menu items. Delete children items from $input_list.
		$out = self::addChildrenToMenu( $out, $in );

		return $out;
	}




//
//  PRIVATE
//
/////////////////////////////////////////////////////////

	private static function getMenuTopLevel( array &$input_list ) : array
	{
		$output_list = [];
		$input_list_count = count( $input_list );
		for ( $i = 0; $i < $input_list_count; $i++ )
		{
			$item = $input_list[ $i ];
			if ( !self::testIsRightType( $item ) )
			{
				throw new ItemNotSortableAsHierarchyException( $item );
			}
			if ( $item->isTopmost() )
			{
				$output_list[] = $item;
				unset( $input_list[ $i ] );
			}
		}
		return $output_list;
	}

	private static function addChildrenToMenu( array $output_list, array $input_list ) : array
	{
		$did_something = true;
		$input_list_count = count( $input_list );
		while ( $input_list_count > 0 && $did_something )
		{
			$did_something = false;
			for ( $i = 0; $i < $input_list_count; $i++ )
			{
				$item = $input_list[ $i ];
				if ( self::testListForSubItem( $output_list, $item ) )
				{
					unset( $input_list[ $i ] );
					$did_something = true;
				}
			}

			// Realign wordpress menu data to clear out deleted indices.
			$input_list = array_values( $input_list );

			// Since the count is different, we need to change our count.
			$input_list_count = count( $input_list );
		}
		return $output_list;
	}

	private static function testListForSubItem( array &$output_list, HierarchicalNode $item ) : bool
	{
		// Look for parent of child menu item & give new item to them.
		foreach ( $output_list as &$output_list_item )
		{
			// If parent is found...
			if ( $output_list_item->getID() === $item->getParent() )
			{
				$output_list_item->addChild( $item );
				return true;
			}
			else
			{
				// If isn't parent, but has children of their own,
				// search through their children, recursively, too.
				if ( $output_list_item->hasChildren() )
				{
					$found_in_child = self::testListForSubItem( $output_list_item->getChildren(), $item );

					// If 'twas found in child, we're done, return with a success flag.
					// Otherwise, we continue.
					if ( $found_in_child )
					{
						return true;
					}
				}
			}
		}

		// We didn't find parent anywhere.
		return false;
	}

	private static function testIsRightType( $item ) : bool
	{
		return $item instanceof HierarchicalNode;
	}
}
