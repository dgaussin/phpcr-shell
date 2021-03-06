<?php

namespace PHPCR\Shell\Console\Helper;

use Symfony\Component\Console\Helper\Helper;

/**
 * Helper for text plain text formatting
 *
 * @author Daniel Leech <daniel@dantleech.com>
 */
class TextHelper extends Helper
{
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'text';
    }

    /**
     * Truncate the given string
     *
     * @param string  $string      String to truncate
     * @param integer $length      Truncate to this length
     * @param string  $alignment   Align to the "left" or the "right"
     * @param string  $delimString String to use to use to indicate the truncation
     *
     * @return string
     */
    public function truncate($string, $length, $alignment = null, $delimString = null)
    {
        $alignment = $alignment === null ? 'left' : $alignment;
        $delimString = $delimString === null ? '...' : $delimString;
        $delimLen = strlen($delimString);

        if (!in_array($alignment, array('left', 'right'))) {
            throw new \InvalidArgumentException(
                'Alignment must either be "left" or "right"'
            );
        }

        if ($delimLen > $length) {
            throw new \InvalidArgumentException(sprintf(
                'Delimiter length "%s" cannot be greater than truncate length "%s"',
                $delimLen, $length
            ));
        }

        if (strlen($string) > $length) {
            $offset = $length - $delimLen;
            if ('left' === $alignment) {
                $string = substr($string, 0, $offset) . $delimString;
            } else {
                $string = $delimString . substr($string,
                    strlen($string) - $offset
                );
            }
        }

        return $string;
    }
}
