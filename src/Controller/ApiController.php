<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class ApiController extends AbstractController
{

    /**
    * @Route("/roll/{dice}/{token}", name="roll", requirements={"dice" = "[bdgpyrf\-]+", "token" = "\d+"}, defaults={"token" = 0})
    */
    public function rollAction($dice, $token)
    {
		$user = NULL;
		if (!empty($token)) {
			$user = $this->getDoctrine()->getRepository(User::class)->findOneByToken($token); //null
		}
		
		$dd = $dice;
        $dice = explode('-', $dice);
        $ret = ['final' => []];

        $bluedice = [false, false, 'success', 'success,cool', 'cool,cool', 'cool']; //6
        $darkdice = [false, false, 'fail', 'fail', 'dis', 'dis'];   //6
        $greendice = [false, 'success', 'success', 'success,success', 'cool', 'cool', 'success,cool', 'cool,cool'];  //8
        $purpledice = [false, 'fail', 'fail,fail', 'dis', 'dis', 'dis', 'dis,dis', 'fail,dis']; //8
        $yellowdice = [false, 'success', 'success', 'success,success', 'success,success', 'cool', 'success,cool', 'success,cool', 'success,cool', 'cool,cool', 'cool,cool', 'trium,success']; //12
        $reddice = [false, 'fail', 'fail', 'fail,fail', 'fail,fail', 'dis', 'dis', 'fail,dis', 'fail,dis', 'dis,dis', 'dis,dis', 'disas,dis'];     //12
        $forcedice = ['dark','dark','dark','dark','dark','dark','dark,dark','light','light','light,light','light,light','light,light']; //12

        $diefaces = ['b' => 6, 'd' => 6, 'g' => 8,'p' => 8,'y' => 12,'r' => 12,'f' => 12];
        $result = ['success' => 0, 'fail' => 0, 'cool' =>0, 'dis' => 0, 'trium' => 0, 'disas' => 0];
        $force = ['light' => 0, 'dark' => 0];

        $r = $f = false;

         /* GET RESULT */
        foreach ($dice as $d) {
	    $rolls = rand(3, 7);

	    for ($i = 0; $i < $rolls; ++$i) {
            switch($diefaces[$d]) {
                case 6:
                         $rand = rand(0, 5);
                    break;

                    case 8:
                         $rand = rand(0, 7);
                    break;

                    case 12:
                         $rand = rand(0, 11);
                    break;
            }}

            switch($d) {
                case 'b':
                        $r = $bluedice[$rand];
                    break;

                    case 'd':
                        $r = $darkdice[$rand];
                    break;

                    case 'g':
                        $r = $greendice[$rand];
                    break;

                    case 'p':
                        $r = $purpledice[$rand];
                    break;

                    case 'y':
                        $r = $yellowdice[$rand];
                    break;

                    case 'r':
                        $r = $reddice[$rand];
                    break;

                    case 'f':
                        $f = $forcedice[$rand];
                    break;
            }
            
            $ret['dice'][$d][] = $r;

            if ($r) {
               $r = explode(',', $r);
               foreach($r as $t) {
                   $result[$t]++;
               }
            }

            if ($f) {
               $f = explode(',', $f);
               foreach($f as $t) {
                   $force[$t]++;
               }    
            }

            $r = false;
            $f = false;    
        }

        /* DIFF RES */
        if ($result['success'] > $result['fail']) {
           $result['success'] -= $result['fail'];
           $result['fail'] = 0;
        } else {
           $result['fail'] -= $result['success'];
           $result['success'] = 0;
        }

        if ($result['cool'] > $result['dis']) {
           $result['cool'] -= $result['dis'];
           $result['dis'] = 0;
        } else {
           $result['dis'] -= $result['cool'];
           $result['cool'] = 0;
        }

          /* PRINT RESULT */
        $val = "";
        foreach($result as $a => $b) {
            while($b > 0) {
               $ret["final"][] = "<img src='/img/faces/".$a.".png' />";
               $b--;

               if ($val === "") {
                $val = $a;
               } else {
                $val .= ",$a";
               }
            }
        }

        foreach($force as $a => $b) {
            while($b > 0) {
                $ret["force"][] = "<img src='/img/faces/".$a.".png' />";
                $b--;

               if ($val === "") {
                $val = $a;
               } else {
                $val .= ",$a";
               }
            }
        }
        
        if (!is_null($user)) {
            $c = $user->getCount()+1;
            $user->setCount($c);
            $user->setResult($val);
			$user->setDice($dd);

            $ret["count"] = $c;
            $em->flush();
        }
        
        return new JsonResponse($ret);
    }
    
    /**
    * @Route("/result/{id}", name="result", requirements={"id" = "\d+"}, defaults={"id" = 0})
    */
    public function resultAction($id)
    {
        $resp = [];
        
        if ($id > 0) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->find($id); //null
            $res = $user->getResult();
            
            if ($res != null) {
                $result = explode(",", $res);
                $resp["count"] = $user->getCount();
                $resp["final"] = $result;
                $resp["id"] = $id;
		$resp["dice"] = explode("-", $user->getDice());
            }
        }
        
        return new JsonResponse($resp);
    }
}
