<?php

namespace App\Modules\Payment\Presentation\Http\Controller;

use App\Modules\Payment\Application\Dto\CreatePaymentDTO;
use App\Modules\Payment\Application\UseCase\CreatePayment\CreatePaymentHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/payments')]
class PaymentController extends AbstractController
{
    #[Route('', methods: ['POST'])]
    public function store(Request $request, CreatePaymentHandler $handler)
    {
        $values = $request->toArray();

        $payment = $handler->execute(
            CreatePaymentDTO::fromArray($values)
        );

        return new JsonResponse(
            data: $payment,
            json: false
        );
    }
}
