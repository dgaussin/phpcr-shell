<?php

namespace spec\PHPCR\Shell\Console\Helper;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use PHPCR\NodeInterface;
use PHPCR\NodeType\NodeTypeInterface;

class NodeHelperSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('PHPCR\Shell\Console\Helper\NodeHelper');
    }

    function it_should_provide_a_method_to_determine_if_a_node_has_a_given_mixin(
        NodeInterface $node,
        NodeTypeInterface $mixin1,
        NodeTypeInterface $mixin2,
        NodeTypeInterface $mixin3
    )
    {
        $node->getMixinNodeTypes()->willReturn(array(
            $mixin1, $mixin2, $mixin3
        ));

        $mixin1->getName()->willReturn('mixin1');
        $mixin2->getName()->willReturn('mixin1');
        $mixin3->getName()->willReturn('mixin3');

        $this->nodeHasMixinType($node, 'mixin1')->shouldReturn(true);
        $this->nodeHasMixinType($node, 'mixin5')->shouldReturn(false);
    }

    function it_should_provide_a_method_to_determine_if_a_node_is_versionable(
        NodeInterface $nodeVersionable,
        NodeInterface $nodeNotVersionable,
        NodeTypeInterface $mixin1,
        NodeTypeInterface $mixin2
    )
    {
        $nodeVersionable->getMixinNodeTypes()->willReturn(array(
            $mixin1, $mixin2
        ));
        $nodeNotVersionable->getMixinNodeTypes()->willReturn(array(
            $mixin2
        ));
        $nodeNotVersionable->getPath()->willReturn('foobar');
        $mixin1->getName()->willReturn('mix:versionable');
        $this->assertNodeIsVersionable($nodeVersionable)->shouldReturn(null);;

        try {
            $this->assertNodeIsVersionable($nodeNotVersionable);
        } catch (\OutOfBoundsException $e) {
        }
    }
}
