<?php
/**
 * Created by PhpStorm.
 * User: jeremie
 * Date: 24/04/18
 * Time: 10:46
 */

namespace TLDBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class ApiGitController extends Controller
{
    /**
     * @Route("/{user}/{repository}")
     * @Method({"GET", "POST"})
     */
    public function apiAction(Request $request)
    {
        $data = $request->attributes;

        $user = $data->get('user');

        $token = 'a4463cf3a630a8ab53f5b1e71dc27dd1764f139e';

        $repository = $data->get('repository');

        $opts = [
            'http' => [
                'method' => 'GET',
                'header' => [
                    'User-Agent: PHP'
                ]
            ]
        ];


        $date_today = new \DateTime();

        $date_since = $date_today->modify('-1 year');

        $dateSince = $date_since->format('Y-m-d');



        $context = stream_context_create($opts);

        $gitHub_json = file_get_contents('https://api.github.com/repos/'.$user.'/'.$repository.'/commits?since='.$dateSince.'&token='.$token,false, $context);

        $gitHub_array = json_decode($gitHub_json,true);



        $count_commit = count($gitHub_array);

        $year = $date_since->format('Y');

        echo $count_commit .' commits</br>';

        echo $year;

        foreach ($gitHub_array as $commit){
            var_dump($commit);
        }

        return $this->render('@TLD/api.html.twig',[
        ]);
    }
}