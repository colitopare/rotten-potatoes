<?php

namespace App\Repository;

use App\Entity\Movie;
use App\Entity\Rating;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
  public function __construct(RegistryInterface $registry)
  {
    parent::__construct($registry, Movie::class);
  }

  public function lastMovieReleasedAt(int $number)
  {
    return $this->createQueryBuilder('m')
      ->select('m')
      ->orderBy('m.releasedAt', 'DESC')
      ->setMaxResults($number)
      ->getQuery()
      ->getResult();
  }


  public function bestMovie(int $number)
  {
    $result = $this->createQueryBuilder('m')
      ->leftJoin('m.ratings', 'r')
      ->orderBy('AVG(r.notation)', 'DESC')
      ->groupBy('m')
      ->setMaxResults($number)
      ->getQuery()
      ->getResult();

    return $result;
  }

  public function pireMovie(int $number)
  {
    $result = $this->createQueryBuilder('m')
      ->leftJoin('m.ratings', 'r')
      ->orderBy('AVG(r.notation)', 'ASC')
      ->groupBy('m')
      ->setMaxResults($number)
      ->getQuery()
      ->getResult();

    return $result;
  }
  /*
    public function findOneBySomeField($value): ?Movie
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
