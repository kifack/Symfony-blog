<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\Security\Core\Security;



class AddArticleController
{
    private $security;

    public function __construct(Security $security){
        $this->security=$security;
    }

    public function __invoke(Article $data){
        $data->setAuthor($this->security->getUser());
        return $data;
    }


}
