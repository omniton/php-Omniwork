<?php

/**
 *
 * Helper to generate system message.
 *
 * @category Solar
 *
 * @package Solar_View_Helper
 *
 * @author Paul M. Jones <pmjones@solarphp.com>
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 * @version $Id: Image.php 4285 2009-12-31 02:18:15Z pmjones $
 *
 */
class Solar_View_Helper_Message extends Solar_View_Helper
{
    /**
     *
     * Returns an message.
     *
     * If an "alt" attribute is not specified, will add it from the
     * image [[php::basename() | ]].
     *
     * @param string $src The href to the image source.
     *
     * @param array $attribs Additional attributes for the tag.
     *
     * @return string An message.
     *
     */
    public function message($fetch = false)
    {
        $session = Solar_Registry::get('session');
        if (!$fetch) {
            return $session->hasFlash('message');
        }

        $aMessage = array('message' => null, 'type' => null);
        if ($session->hasFlash('message')) {
            $aMessage['message'] = $session->getFlash('message');
            $type = $session->getFlash('messageType');
            $aMessage['type'] = $type ? $type : 'error';
        }
        return $aMessage;
    }
}
