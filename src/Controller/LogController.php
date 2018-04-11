<?php

namespace App\Controller;

use App\Entity\Log;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Brand controller.
 *
 * @Route("/")
 */
class LogController extends Controller
{

    /**
     * Lists all logs.
     *
     * @FOSRest\View
     * @FOSRest\Get("/log")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getLogsAction()
    {
        $repository = $this->getDoctrine()->getRepository(Log::class);
        $logs = $repository->findAll();

        return View::create($logs, Response::HTTP_OK, [])->getResponse();
    }

    /**
     * Get a specified log.
     *
     * @param int $id - Log id.
     *
     * @FOSRest\View
     * @FOSRest\Get("/log/{id}", requirements={"id" = "\d+"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getLogAction($id, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Log::class);
        $log = $repository->find($id);

        $view = View::create($log, Response::HTTP_OK, []);
        $handler = $this->get('fos_rest.view_handler');

        return $handler->createResponse($view, $request, 'json');

    }

    /**
     * Create a log entry.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request - Request.
     *
     * @FOSRest\Post("/log")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createLogAction(Request $request)
    {
        $log = new Log();
        $log->setCode($request->get('code'));
        $log->setMessage($request->get('message'));
        $log->setContext($request->get('context'));
        $log->setLevel($request->get('level'));
        $log->setLevelName($request->get('level_name'));
        $log->setExtra($request->get('extra'));
        $log->setCreatedAt(new \DateTime());
        $em = $this->getDoctrine()->getManager();
        $em->persist($log);
        $em->flush();

        $view = View::create($log, Response::HTTP_CREATED, []);
        return $view->getResponse();
    }

}
