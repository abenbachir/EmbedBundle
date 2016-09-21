<?php

namespace Embed\Bundle\EmbedBundle\Essence;


use \Essence\Essence as Essence;

class EssenceEmbedded
{
    /** @var Essence $identity */
    private $identity;

    public function __construct()
    {
        $this->identity = Essence::instance();
    }


    /**
     * @param $url
     * @param array $options
     * @return \Essence\Media
     */
    public function embed($url, array $options = [ ])
    {
        return $this->identity->embed($url, $options);
    }
}