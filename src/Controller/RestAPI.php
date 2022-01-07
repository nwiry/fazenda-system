<?php

namespace App\Controller;

use App\Entity\PDOConnection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class RestAPI extends AbstractController
{
    /**
     * @Route("/api/v1/programmers")
     * @Method("GET")
     */
    public function list_cattle(Request $request)
    {
        try {
            $pdo = PDOConnection::sqlite();
            $stmt = $pdo->prepare("SELECT * FROM `farm_cattle`");
            $stmt->execute();
            return $this->json([
                'data' => $stmt->fetchAll()
            ]);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}