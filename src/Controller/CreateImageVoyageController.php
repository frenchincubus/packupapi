<?php
// api/src/Controller/CreateImageVoyageController.php

namespace App\Controller;

use App\Entity\ImageVoyage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class CreateImageVoyageController
{
    public function __invoke(Request $request): ImageVoyage
    {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $image = new ImageVoyage();
        $image->file = $uploadedFile;

        return $image;
    }
}