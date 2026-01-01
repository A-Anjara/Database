<?php

namespace App\Application;

use App\Entity\Membre;
use App\Entity\Sikla0;
use App\Entity\Transaction;
use App\Entity\TypeTransaction;
use App\Entity\Utilisateur;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class DataBaseApplication
{
    public EntityManagerInterface $em;
    public $COLUMN = [
        "id" => 0,
        "nom" => 1,
        "email" => 2,
        "code" => 3,
        "parent" => 4,
        "adresse" => 5,
        "telephone" => 6,
        "fokontany" => 7,
        "activite" => 8,
        "nif" => 9,
        "personne" => 10,
        "payer" => 11,
        "montant" => 12
    ];
    public DateTime $date;
    public int $BATCH_SIZE = 200;
    public int $BATCH_COUNT = 0;

    public function __construct(EntityManagerInterface $em)
    {

        $this->em = $em;
    }


    public function add($object)
    {
        $this->em->persist($object);
        $this->BATCH_COUNT++;
        if ($this->BATCH_COUNT >= $this->BATCH_SIZE) {
            $this->em->flush();
            $this->em->clear();
            usleep(300000);
            $this->BATCH_COUNT = 0;
        }
    }

    public function parse_datetime(string $str)
    {
        // Le nom du fichier doit avoir la date
        $reg = preg_match("/(\d+)-(\d+)-(\d+)-(\d+)\.(\d+)\.(\d+)/i", $str, $rawdate);

        if ($reg) {

            $this->date = new DateTime($rawdate[1] . '-' . $rawdate[2] . '-' . $rawdate[3] . 'T' . $rawdate[4] . ':' . $rawdate[5] . ':' . $rawdate[6] . '+03:00');
            $this->date->setTimezone(new DateTimeZone('UTC'));
        } else {
            throw new Exception("Le nom du fichier Excel doit avoir la date de format yyyy-mm-jj-hh-mm-ss !");
        }
    }

    public function insertUsers(array $rows)
    {

        $conn = $this->em->getConnection();


        $conn->beginTransaction();
        // Detecter le dernier ID inséré
        $last = $this->em->getRepository(Utilisateur::class)->findBy([], ['id' => 'DESC'], 1);
        $last = ($last) ? $last[0]->getId() : 0;
        $relations = [];

        
        // UTILISATEUR
        try {
            foreach ($rows as $key => $row) {
                // MISE À JOUR DES UTILISATEURS EXISTANTS
                
                if ((int) $row[$this->COLUMN['id']] <= $last) {
                    $result = $this->tryUpdateUser($row);
                    if (!is_null($result)) {
                        $this->add($result);
                    }
                } else {
                    // CREATION UTILISATEUR
                    $this->add($this->createUser($row));

                    // RELATIONS PARRAINAGE : [id,parrain]
                    $relations[] = [(int) $row[$this->COLUMN['id']], (int) $row[$this->COLUMN['parent']]];
                }
            }
            // DERNIER FLUSH
            $this->em->flush();
            $this->em->clear();
            usleep(300000);
            $this->BATCH_COUNT = 0;
            $conn->commit();
        } catch (Exception $e) {

            $conn->rollBack();
            throw $e;
        }



        // PARRAINAGE
        foreach ($relations as $key => $value) {
            $this->em->persist($this->createParrainage($value));
        }
        $this->em->flush();
        $this->em->clear();
        usleep(300000);


        // Mis à Jour Sikla0
        $this->updateSikla0();
    }



    public function createUser(array $value): Utilisateur
    {
        //Creation de l'utilisateur
        $user = new Utilisateur();
        $user->setId($value[$this->COLUMN['id']]);
        $user->setNom($value[$this->COLUMN['nom']]);
        $user->setEmail($value[$this->COLUMN['email']]);
        $user->setCode($value[$this->COLUMN['code']]);
        $user->setAdresse($value[$this->COLUMN['adresse']]);
        $user->setTelephone($value[$this->COLUMN['telephone']]);
        $user->setFokontany($value[$this->COLUMN['fokontany']]);
        $user->setActivite($value[$this->COLUMN['activite']]);
        $user->setNif($value[$this->COLUMN['nif']]);
        $user->setPersonne($value[$this->COLUMN['personne']]);

        // Si l'utilisateur a déposé , on comptabilise dans 'Transaction'
        $deposit = $this->userDeposit((int) $value[$this->COLUMN['montant']]);
        if (!is_null($deposit)) {
            $deposit->setUtilisateur($user);
            $this->em->persist($deposit);
            $user->setSolde((int) $value[$this->COLUMN['montant']]);
        }

        $user->setDate($this->date);
        return $user;
    }

    public function userDeposit(int $montant): Transaction|null
    {
        if ($montant > 0) {
            $transaction = new Transaction();
            $transaction->setDate($this->date);
            $transaction->setMontant($montant);
            $transaction->setType($this->em->getRepository(TypeTransaction::class)->findOneBy(['libelle' => 'Depot']));
            return $transaction;
        }
        return null;
    }

    public function createParrainage(array $value): Utilisateur
    {
        $user = $this->em->getRepository(Utilisateur::class)->find($value[0]);
        $parent = $this->em->getRepository(Utilisateur::class)->find($value[1]);
        $user->setParent($parent);
        return $user;
    }

    function tryUpdateUser(array $value)
    {
        $state = 0;
        $user = $this->em->getRepository(Utilisateur::class)->find($value[$this->COLUMN['id']]);

        if ($user->getNom() != $value[$this->COLUMN['nom']]) {
            $user->setNom($value[$this->COLUMN['nom']]);
            $state = 1;
        }


        if ($user->getEmail() != $value[$this->COLUMN['email']]) {
            $user->setEmail($value[$this->COLUMN['email']]);
            $state = 1;
        }

        if ($user->getCode() != $value[$this->COLUMN['code']]) {
            $user->setCode($value[$this->COLUMN['code']]);
            $state = 1;
        }


        if ($user->getAdresse() != $value[$this->COLUMN['adresse']]) {
            $user->setAdresse($value[$this->COLUMN['adresse']]);
            $state = 1;
        }


        if ($user->getTelephone() != str_replace(" ", "", $value[$this->COLUMN['telephone']])) {
            $user->setTelephone($value[$this->COLUMN['telephone']]);
            $state = 1;
        }


        if ($user->getFokontany() != $value[$this->COLUMN['fokontany']]) {
            $user->setFokontany($value[$this->COLUMN['fokontany']]);
            $state = 1;
        }

        if ($user->getActivite() != $value[$this->COLUMN['activite']]) {
            $user->setActivite($value[$this->COLUMN['activite']]);
            $state = 1;
        }

        if ($user->getNif() != str_replace(" ", "", $value[$this->COLUMN['nif']])) {
            $user->setNif($value[$this->COLUMN['nif']]);
            $state = 1;
        }

        if ($user->getPersonne() != (preg_match('/(MORALE)/i', $value[$this->COLUMN['personne']]) ? "MORALE" : "PHYSIQUE")) {
            $user->setPersonne($value[$this->COLUMN['personne']]);
            $state = 1;
        }

        // L'utilisateur a fait un nouveau dépot
        $diff = $this->checkDepositsDifference($user, (int) $value[$this->COLUMN['montant']]);
        $transaction = $this->userDeposit($diff);
        if (!is_null($transaction)) {
            $transaction->setUtilisateur($user);
            $user->setSolde($user->getSolde() + $diff);
            $this->em->persist($transaction);
            $state = 1;
        }

        if ($state) {
            return $user;
        }
        return null;
    }


    public function checkDepositsDifference(Utilisateur $user, int $montant)
    {

        // Verifie si l'Utilisateur a déposé de nouveau en verifiant la somme des depots et le montant
        $deposit_id = $this->em->getRepository(TypeTransaction::class)->findOneBy(['libelle' => 'Depot'])->getId();
        $transactions = $this->em->getRepository(Transaction::class)->findBy(['utilisateur' => $user->getId(), 'type' => $deposit_id]);

        $sum = 0;
        foreach ($transactions as $transaction) {
            $sum += $transaction->getMontant();
        }

        return ($montant -  $sum);
    }





    public function updateSikla0()
    {
        $conn = $this->em->getConnection();
        $query = "
        SELECT u.id id FROM utilisateur u
        LEFT JOIN sikla0 s ON
        s.utilisateur_id = u.id
        WHERE (u.solde>=10000) AND (s.id IS NULL);
        ";
        $query_result = $conn->executeQuery($query);
        $query_result = $query_result->fetchAllAssociative();


        $user_repository = $this->em->getRepository(Utilisateur::class);
        // Ajouter l'utilisateur dans Sikla0
        foreach ($query_result as $row) {
            $user = $user_repository->find($row['id']);

            $this->addSikla0($user);
        }
        // ? Mettre à jour le repository ?
        $user_repository = $this->em->getRepository(Utilisateur::class);

        // Verifier si ils sont eligible d'être membre
        foreach ($query_result as $row) {
            // L'utilisateur
            $user = $user_repository->find($row['id']);
            $this->checkSikla0($user);

            // Parent
            $user = $user->getParent();
            if(is_null($user)){
                continue;
            }
            $this->checkSikla0($user);

            // Racine
            $user = $user->getParent();
            if(is_null($user)){
                continue;
            }
            $this->checkSikla0($user);
        }
    }



    public function addSikla0(Utilisateur $user)
    {
        $sikla0 = new Sikla0();
        $sikla0->setDate($this->date);
        $sikla0->setUtilisateur($user);

        // Comptabiliisation (Sikla0 coûte 10.000 Ar)
        $user->setSolde($user->getSolde() - 10000);
        $transaction = new Transaction();
        $transaction->setDate($this->date);
        $transaction->setMontant(10000);
        $transaction->setUtilisateur($user);
        $transaction->setType($this->em->getRepository(TypeTransaction::class)->findOneBy(['libelle' => 'Investissement Sikla 0']));

        $this->em->persist($transaction);
        $this->em->persist($sikla0);
        $this->em->persist($user);
        $this->em->flush();
        $this->em->clear();
    }


    public function checkSikla0(Utilisateur $user)
    {   
        $user_id = $user->getId();
        $check_membre = $this->em->getRepository(Membre::class)->findBy(['utilisateur' => $user_id]);
        if(count($check_membre)>0){
            return;
        }
        $conn = $this->em->getConnection();
        $query = "
        SELECT u1.id direct,COUNT(u2.id) indirect FROM utilisateur u1

        JOIN sikla0 s1 ON
        s1.utilisateur_id = u1.id

        LEFT JOIN utilisateur u2 ON
        u2.parent_id = u1.id

        JOIN sikla0 s2 ON
        u2.id = s2.utilisateur_id
        
        WHERE u1.parent_id = $user_id
        GROUP BY direct
        ORDER BY indirect DESC;
        ";
        $result = $conn->executeQuery($query);
        $result = $result->fetchAllAssociative();

        if (count($result) < 2) {
            return;
        }
        $n = 0;
        while ($n < 2) {
            if ((int) $result[$n]['indirect'] < 2) {
                return;
            }
            $n++;
        }

        // Ajouter dans Membre
        $membre = new Membre();
        $membre->setDate($this->date);
        $membre->setUtilisateur($user);

        // Realiser le Sikla0
        $sikla = $this->em->getRepository(Sikla0::class)->findOneBy(['utilisateur' => $user_id]);
        $sikla->setRealise($this->date);

        // Comptabiliser
        $user->setSolde($user->getSolde() + 20000);
        $transaction = new Transaction();
        $transaction->setDate($this->date);
        $transaction->setUtilisateur($user);
        $transaction->setType($this->em->getRepository(TypeTransaction::class)->findOneBy(['libelle' => 'Recompense Sikla 0']));
        $transaction->setMontant(20000);

        $this->em->persist($transaction);
        $this->em->persist($sikla);
        $this->em->persist($membre);
        $this->em->persist($user);
        $this->em->flush();
        $this->em->clear();
    }

    
}
