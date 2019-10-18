<?php

declare( strict_types = 1 );
namespace WaughJ\FlatToHierarchySorter;

class HierarchicalNode
{
	public function __construct( int $id, int $parent_id, array $children = [] )
	{
		$this->id = $id;
		$this->parent = $parent_id;
		$this->children = $children;
	}

	public function getID() : int
	{
		return $this->id;
	}

	public function getParent() : int
	{
		return $this->parent;
	}

	public function isTopMost() : bool
	{
		return $this->getParent() === 0;
	}

	public function &getChildren() : array
	{
		return $this->children;
	}

	public function hasChildren() : bool
	{
		return !empty( $this->children );
	}

	public function addChild( HierarchicalNode $item ) : void
	{
		$this->children[] = $item;
	}

	private $id;
	private $parent;
	private $children;
}