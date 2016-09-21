<?php

namespace Embed\Bundle\EmbedBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EmbedController
 * @package Embed\Bundle\EmbedBundle\Controller
 *
 * @Route("/embed")
 */
class EmbedController extends Controller
{
    /**
     * @Route("")
     * @Method({"POST"})
     */
    public function indexAction(Request $request)
    {
        try{
            $url = $request->request->get('url');
            /** @var \Essence\Media $media */
            $media = $this->get('embed.essence')->embed($url, ['maxwidth'=>'640','maxheight'=>'480', 'allowfullscreen'=>'0']);

            $html = $this->get('templating')->render('EmbedBundle:Media:video.html.twig', [
                'url' => $url,
                'media' => $media
            ]);

            return $this->Json([
                'url' => $url,
                'media' => $media
            ]);
        }catch(\Exception $ex){
            return $this->Json($ex->getMessage(), false);
        }
    }

    protected function Json($param = array(), $success = true)
    {
        $serializer = $this->get('serializer');
        $result = $serializer->serialize($param, 'json');
        $responseStatus = $success ? 200 : 500;
        return new Response($result, $responseStatus, array("content-type"=> "text/json"));
    }

}
