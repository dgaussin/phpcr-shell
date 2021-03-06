<?php

namespace spec\PHPCR\Shell\Event;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use PHPCR\Shell\Config\Profile;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProfileInitEventSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('PHPCR\Shell\Event\ProfileInitEvent');
    }

    function let(
        Profile $profile,
        InputInterface $input,
        OutputInterface $output
    ) 
    {
        $this->beConstructedWith(
            $profile, $input, $output
        );
    }

    function it_should_have_getters(
        Profile $profile,
        InputInterface $input,
        OutputInterface $output
    )
    {
        $this->getProfile()->shouldReturn($profile);
        $this->getInput()->shouldReturn($input);
        $this->getOutput()->shouldReturn($output);
    }
}
