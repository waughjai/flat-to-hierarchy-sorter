Flat to Hierarchy Sorter
=========================

Sorts flat list of nodes with IDs and parent IDs into layered list of nodes with IDs and lists of children to make iteration easier.

## Example

    use WaughJ\FlatToHierarchySorter\FlatToHierarchySorter;
    use WaughJ\FlatToHierarchySorter\HierarchicalNode;

    $old_list =
    [
        new HierarchicalNode( 1, 0 ),
        new HierarchicalNode( 2, 1 ),
        new HierarchicalNode( 3, 1 ),
        new HierarchicalNode( 4, 2 )
    ];
    $sorted_list = FlatToHierarchySorter::sort( $old_list );

will return to equivalent of:

    new HierarchicalNode
    (
        1,
        0,
        [
            new HierarchicalNode( 2, 1, [ new HierarchicalNode( 4, 2 ) ] ),
            new HierarchicalNode( 3, 1 )
        ]
    );

## Changelog

### 0.1.0
* Initial release