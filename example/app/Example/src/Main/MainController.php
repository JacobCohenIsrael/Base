<?php
namespace JCI\Example\Main;

use JCI\Base\Http\Controller\Controller;
use JCI\Base\Http\JsonResponse;

class MainController extends Controller
{
    public function main()
    {
        return new JsonResponse(['success' => true]);    
    }
}

