<?php

declare( strict_types = 1 );

use PHPUnit\Framework\TestCase;
use WaughJ\FlatToHierarchySorter\FlatToHierarchySorter;
use WaughJ\FlatToHierarchySorter\ItemNotSortableAsHierarchyException;
use WaughJ\FlatToHierarchySorter\HierarchicalNode;

class FlatToHierarchySorterTest extends TestCase
{
	public function testSortingInvalidObjects() : void
	{
		$this->expectException( ItemNotSortableAsHierarchyException::class );
		$new_list = FlatToHierarchySorter::sort( [ 1, 5, 'hello', [] ] );
	}

	public function testSorter() : void
	{
		$new_list = FlatToHierarchySorter::sort( self::getTestList() );
		$this->assertEquals( $new_list, $this->getTestSortedList() );
	}

	private static function getTestList() : array
	{
		return
		[
			new TestNode( 1, 0 ),
			new TestNode( 2, 1 ),
			new TestNode( 3, 1 ),
			new TestNode( 4, 2 )
		];
	}

	private static function getTestSortedList() : array
	{
		return
		[
			new TestNode
			(
				1,
				0,
				[
					new TestNode( 2, 1, [ new TestNode( 4, 2 ) ] ),
					new TestNode( 3, 1 )
				]
			)
		];
	}
}

class TestNode extends HierarchicalNode
{
	public function __construct( int $id, int $parent, array $children = [] )
	{
		parent::__construct( $id, $parent, $children );
		$this->extra = "EXTRA";
	}

	public function getExtra() : string
	{
		return $this->extra;
	}

	private $extra;
}