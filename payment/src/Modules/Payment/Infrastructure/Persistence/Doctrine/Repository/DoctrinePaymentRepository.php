<?php

// namespace App\Repository;
namespace App\Modules\Payment\Infrastructure\Persistence\Doctrine\Repository;

use App\Modules\Payment\Domain\Entity\Payment;
use App\Modules\Payment\Domain\Repository\PaymentRepositoryInterface;
use App\Modules\Payment\Infrastructure\Persistence\Doctrine\Entity\PaymentModel;
use App\Modules\Payment\Infrastructure\Persistence\Doctrine\Mapper\PaymentMapper;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PaymentModel>
 */
class DoctrinePaymentRepository extends ServiceEntityRepository implements PaymentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry, private PaymentMapper $paymentMapper)
    {
        parent::__construct($registry, PaymentModel::class);
    }

    public function store(Payment $payment): void
    {
        $em = $this->getEntityManager();

        $entity = $this->paymentMapper->toDoctrine($payment);

        $em->persist($entity);
    }

    public function update(Payment $payment): void
    {
        $em = $this->getEntityManager();

        $paymentModel = $em->find(PaymentModel::class, $payment->id);

        $em->persist($this->paymentMapper->updateForDoctrine($payment, $paymentModel));
    }

    //    /**
    //     * @return PaymentModel[] Returns an array of PaymentModel objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PaymentModel
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
