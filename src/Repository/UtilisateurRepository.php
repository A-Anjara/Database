<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Utilisateur>
 */
class UtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

    //    /**
    //     * @return Utilisateur[] Returns an array of Utilisateur objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Utilisateur
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


    public function getUserInfo(int $id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $left_query = "
        SELECT u2.nom parent,
        S.id cotisant, 
        m.id membre, 
        u1.solde solde, 
        COUNT(u3.id) parraine

        FROM utilisateur u1

        LEFT JOIN utilisateur u2
        ON u2.id = u1.parent_id
        
        LEFT JOIN sikla0 S
        ON S.utilisateur_id = u1.id
        
        LEFT JOIN membre m
        ON m.utilisateur_id = u1.id
        
        LEFT JOIN utilisateur u3
        ON u3.parent_id = u1.id

        WHERE u1.id=$id;
        
        ";
        $left_value = $conn->executeQuery($left_query);


        $right_query = "
        SELECT u1.id direct,COUNT(u2.id) indirect FROM utilisateur u1

        JOIN sikla0 s1 ON
        s1.utilisateur_id = u1.id

        LEFT JOIN utilisateur u2 ON
        u2.parent_id = u1.id

        JOIN sikla0 s2 ON
        u2.id = s2.utilisateur_id
        
        WHERE u1.parent_id = $id
        GROUP BY direct
        ORDER BY indirect DESC;

        ";

        $right_value = $conn->executeQuery($right_query);

        return [...($left_value->fetchAllAssociative()), 'enfants' => ($right_value->fetchAllAssociative())];
    }

    public function getUserParrainage(int $id)
    {
        $conn = $this->getEntityManager()->getConnection();
        $result = $conn->executeQuery(
            "
            SELECT nom,
            date
            
            FROM utilisateur
            
            WHERE parent_id = $id;
            "
        );

        return $result->fetchAllAssociative();
    }


    public function getUserTransaction(int $id)
    {
        $conn = $this->getEntityManager()->getConnection();
        $result = $conn->executeQuery(
            "
            SELECT montant,
            date,
            libelle,
            signe
            FROM transaction

            JOIN type_transaction
            ON type_id = type_transaction.id

            WHERE utilisateur_id = $id
            "
        );

        return $result->fetchAllAssociative();
    }

    public function getExport()
    {
        $conn = $this->getEntityManager()->getConnection();
        $result = $conn->executeQuery(
            "
            SELECT 
            u.*,
            s0.id sikla0,
            m.date membre

            FROM utilisateur u
	    
            LEFT JOIN sikla0 s0
            ON s0.utilisateur_id = u.id

            LEFT JOIN membre m
            ON m.utilisateur_id = u.id

            "
        );

        return $result->fetchAllAssociative();
    }




}





// $this->addSql("
//         INSERT INTO type_transaction (libelle,signe) VALUES 
//         ('Depot',1),
//         ('Retrait',-1),
//         ('Investissement Sikla',-1),
//         ('Recompense Sikla',1)
//         ");
